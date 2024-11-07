<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Order extends Model
{


    public $fillable = [
        'event_id',
        'event_date',
        'equal_price',
    ];

    public function tickets() : HasMany
    {
        return $this->hasMany(OrderTicket::class);
    }

    public function store($event_id,$equal_price,$event_date){

        $order = new Order();

        $order->event_id = $event_id;
        $order->event_date = $event_date;
        $order->equal_price = $equal_price;

        $order->save();
        return $order->id;
    }
}
