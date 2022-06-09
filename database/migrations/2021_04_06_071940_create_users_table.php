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
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->text('password');
            $table->string('phone')->nullable();
            $table->integer('role')->nullable();
            $table->text('address')->nullable();
            $table->date('birth')->nullable();
            $table->text('avatar')->nullable();
            $table->string('nik')->nullable();
            $table->string('identity_pict')->nullable();
            $table->string('position')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('otp')->nullable();
            $table->dateTime('otp_expired')->nullable();
            $table->string('relation_id', 10)->unique();
            $table->rememberToken();
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
