<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(SaleSeeder::class);
        $this->call(BatchSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(ItemSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
