<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('is_admin');
            $table->integer('is_active');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('scid')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // INSERT DEFAULT ADMIN ACCOUNT
        DB::table('users')->insert(
        array(
            'name' => 'admin@gmail.com',
            'password' => '$2y$10$1cbdzXESQS3kr53ZK3yuce9BpU2rlI5vBZPZnreLfiA3gVyVqx9Ue',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'is_admin' => 1,
            'is_active' => 1
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
