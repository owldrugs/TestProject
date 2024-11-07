<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderTicket;
use App\Models\TicketType;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * @param $event_id
     * @param $event_date
     * @param $tickets = [
     *      ['type_id'=>$ticket_type_id]
     * ]
     * @return void
     * @throws \Exception
     */
    public function createOrder($event_id, $event_date, $tickets): void
    {
        $barcode = "";

        foreach ($tickets as $key => $ticket) {
            do {
                $tickets[$key]['barcode'] = $this->generateUniqueBarcode();
            } while (!empty(DB::table('order_tickets')->where('barcode', $tickets[$key]['barcode'])->first()));

        }
        //
        $response = $this->bookOrder($event_id, $event_date, $tickets);

        if ($response['error'] ?? null) {
            if ($response['error'] === 'barcode already exists') {
                $this->createOrder($event_id, $event_date, $tickets);
            }
            throw new \Exception('Не удалось забронировать заказ: ' . $response['error']);
            die();
        }

        $confirmResponse = $this->approveOrder($event_id, $event_date, $tickets);

        if ($confirmResponse['error'] ?? null) {
            throw new \Exception('Ошибка подтверждения заказа: ' . $confirmResponse['error']);
            die();
        }

        $this->saveOrder($event_id, $event_date, $tickets);
    }

    protected function generateUniqueBarcode($length = 10): string
    {
        $barcode = "";
        for ($i = 0; $i < $length; $i++) {
            $barcode .= random_int(0, 9);
        }
        return $barcode; // Генерация случайного строки 10 символов
    }

    protected function bookOrder($event_id, $event_date, $tickets): array
    {
        // В обычной ситуации будет: $response = Http::post('https://api.site.com/book', [...]);

        // Мок ответа
        $mockResponses = [
            ['message' => 'order successfully booked'],
            ['error' => 'barcode already exists'],
        ];

        return $mockResponses[array_rand($mockResponses)];
    }

    protected function approveOrder($barcode): array
    {
        // В обычной ситуации будет: $response = Http::post('https://api.site.com/approve', ['barcode' => $barcode]);

        // Мок ответа
        $mockResponses = [
            ['message' => 'order successfully aproved'],
            ['error' => 'event cancelled'],
            ['error' => 'no tickets'],
            ['error' => 'no seats'],
            ['error' => 'fan removed'],
        ];

        return $mockResponses[array_rand($mockResponses)];
    }

    protected function saveOrder($event_id, $event_date, $tickets): void
    {
        $equal_price = 0;
        foreach ($tickets as $key => $ticket) {
            $priceOfTicket = TicketType::all()->where('id', $ticket['type_id'])->first()->price;
            $equal_price += $priceOfTicket;
            $tickets[$key]['price'] = $priceOfTicket;
        }

        $order = new Order();
        $order_id = $order->store($event_id, $equal_price, $event_date);

        foreach ($tickets as $item) {
            $order_ticket = new OrderTicket();

            $order_ticket->store($order_id, $item['type_id'], $item['barcode']);
        }
    }

}
