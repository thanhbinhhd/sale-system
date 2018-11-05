q<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('quantity');
            $table->string('description')->nullable();
            $table->text('review')->nullable();
            $table->decimal('price', 13, 2);
            $table->integer('number_viewed')->default(0);
            $table->integer('status')->default(1)->comment('1: active, 0: inactive, 2: reject');
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
