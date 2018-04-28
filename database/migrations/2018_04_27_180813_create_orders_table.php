<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('card_id')->unsigned()->references('id')->on('cards');
            $table->integer('user_id')->unsigned()->references('id')->on('users');
            $table->boolean('write_off');
            $table->float('order_sum');
            $table->boolean('examined')->default(false);
            $table->boolean('approved')->default(false);
            $table->date('date_approved')->nullable()->default(null);
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
        Schema::dropIfExists('orders');
    }
}
