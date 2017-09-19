<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('original_name');
            $table->string('full_path');
            $table->string('path');
            $table->boolean('main_image')->default(false);
            $table->boolean('default_image')->default(true);
            $table->unsignedInteger('equipment_id')->nullable();
            $table->unsignedInteger('portfolio_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('equipment_id')->references('id')->on('equipments');
            $table->foreign('portfolio_id')->references('id')->on('portfolios');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
