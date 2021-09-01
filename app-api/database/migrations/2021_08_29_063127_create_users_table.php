<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('email', 128)->nullable()->unique();;
            $table->string('phone', 128)->unique();
            $table->boolean('otp_confirmed', 128)->default('0');
            $table->string('id_card', 128)->nullable()->unique();
            $table->string('name', 128)->nullable();
            $table->string('lastname', 128)->nullable();
            $table->date('birthday', 128)->nullable();
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
        Schema::dropIfExists('users');
    }
}