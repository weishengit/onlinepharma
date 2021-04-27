<?php

use App\Models\Tax;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('rate');
            $table->integer('is_active');
            $table->timestamps();
        });

        // DEFAULT TAXES
        Tax::create(['id' => 1, 'name' => 'none', 'rate' => 0]);
        Tax::create(['id' => 2, 'name' => 'VAT Exempt', 'rate' => 0]);
        Tax::create(['id' => 3, 'name' => 'VAT 12%', 'rate' => 0.12]);
        Tax::create(['id' => 4, 'name' => 'VAT 5%', 'rate' => 0.05]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxes');
    }
}
