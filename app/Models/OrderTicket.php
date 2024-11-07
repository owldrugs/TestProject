<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class OrderTicket extends Model
{
    protected $fillable = [
        'order_id',
        'ticket_type_id',
        'barcode',
    ];

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function ticketType() : BelongsTo
    {
        return $this->belongsTo(TicketType::class);
    }

    public function store($order_id, $ticket_type_id, $barcode){
        $orderTicket = new OrderTicket();
        $orderTicket->order_id = $order_id;
        $orderTicket->ticket_type_id = $ticket_type_id;
        $orderTicket->barcode = $barcode;

        $orderTicket->save();

        return $orderTicket->id;
    }
}
