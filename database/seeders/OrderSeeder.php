<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()->count(5)->has(Item::factory()->count(3))->create();
    }
}
