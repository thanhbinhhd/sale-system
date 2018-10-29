<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id');
            $table->boolean('can_delete')->default(false);
            $table->boolean('can_add')->default(false);
            $table->boolean('can_update')->default(false);
            $table->boolean('can_read')->default(false);
            $table->boolean('can_accept_order')->default(false);
            $table->boolean('can_reject_order')->default(false);
            $table->boolean('can_view_order_history')->default(false);
            $table->boolean('can_view_user')->default(false);
            $table->boolean('can_block_user')->default(false);
            $table->boolean('can_change_policies')->default(false);
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
        Schema::dropIfExists('admin_permissions');
    }
}
