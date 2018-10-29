<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cpu')->nullable();
            $table->tinyInteger('ram')->nullable();
            $table->string('screen')->nullable();
            $table->string('storage')->nullable();
            $table->string('exten_memory')->nullable();
            $table->string('cam1')->nullable();
            $table->string('cam2')->nullable();
            $table->string('sim')->nullable();
            $table->string('connect')->nullable();
            $table->string('pin')->nullable();
            $table->string('os')->nullable();
            $table->text('note')->nullable();
            $table->integer('product_id')->unsigned();
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
        Schema::dropIfExists('product_details');
    }
}
