<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable();
            $table->foreignId('tax_id')->nullable();
            $table->string('name');
            $table->string('generic_name')->nullable();
            $table->string('drug_class')->nullable();
            $table->string('description');
            $table->decimal('price');
            $table->string('measurement')->nullable();
            $table->bigInteger('critical_level');
            $table->boolean('is_prescription');
            $table->boolean('is_available');
            $table->boolean('is_active');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
