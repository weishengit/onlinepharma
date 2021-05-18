<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('email');
            $table->string('contact');
            $table->string('delivery_fee');
            $table->timestamps();
        });

        // DEFAULT SETTING
        Setting::create([
            'id' => 1,
            'name' => 'Online Pharma',
            'address' => '42 Work St., Bussiness Avenue, M City',
            'email' => 'emailaddress@domain.com',
            'contact' => '0927-449-6838',
            'delivery_fee' => 30
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
