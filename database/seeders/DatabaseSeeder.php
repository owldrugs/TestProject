<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //5 случайных событий
        Event::factory(5)->create();

        //5 типо билетов
        TicketType::factory()->create([
            'name'=>'Для взрослых',
            'price'=>450
        ]);

        TicketType::factory()->create([
            'name'=>'Для детей',
            'price'=>450
        ]);

        TicketType::factory()->create([
            'name'=>'Для льготников',
            'price'=>250
        ]);
    }
}
