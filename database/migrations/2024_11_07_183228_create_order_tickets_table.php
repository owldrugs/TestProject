<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders'); // Внешний ключ на заказ
            $table->foreignId('ticket_type_id')->constrained('ticket_types'); // Внешний ключ на тип билета
            $table->string('barcode')->unique(); // Уникальный штрих-код для билета
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_tickets');
    }
};
