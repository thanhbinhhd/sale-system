<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->nullable();
            $table->integer('product_id');
            $table->integer('admin_id');
            $table->integer('promo')->comment('sale percents');
            $table->integer('promo_code')->nullable()->comment('sale code');
            $table->boolean('type')->default(true)->comment('true is public sales, false is private sale');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
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
        Schema::dropIfExists('product_sales');
    }
}
