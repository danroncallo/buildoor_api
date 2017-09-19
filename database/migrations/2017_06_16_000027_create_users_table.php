<?php

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
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('identification')->nullable();
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('email')->unique()->nullable();;
            $table->string('profession')->nullable();
            $table->text('address')->nullable();
            $table->text('postal_code')->nullable();
            $table->string('status')->default('active');
            $table->string('password')->nullable();
            $table->boolean('private')->default(0);
//            $table->string('provider')->nullable();
//            $table->string('provider_id')->nullable();
            $table->rememberToken()->nullable();
            $table->string('state')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('role_id')->nullable();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('role_id')->references('id')->on('roles');
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
