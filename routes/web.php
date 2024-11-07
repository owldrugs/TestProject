<?php

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $orderService = new OrderService();

    $orderService->createOrder(1,"12.20.20",[
        ['type_id'=>1],
        ['type_id'=>2],
        ['type_id'=>2],
        ['type_id'=>3],
    ]);
});
