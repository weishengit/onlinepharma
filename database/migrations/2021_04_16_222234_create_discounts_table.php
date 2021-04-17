<?php

use App\Models\Discount;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('rate');
            $table->integer('is_active');
            $table->timestamps();
        });

        // DEFAULT TAXES
        Discount::create(['id' => 1, 'name' => 'none', 'rate' => 0]);
        Discount::create(['id' => 2, 'name' => 'Senior 20%', 'rate' => 0.20]);
        Discount::create(['id' => 3, 'name' => 'PWD 20%', 'rate' => 0.20]);
        Discount::create(['id' => 4, 'name' => '5%', 'rate' => 0.05]);
        Discount::create(['id' => 5, 'name' => '10%', 'rate' => 0.10]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
