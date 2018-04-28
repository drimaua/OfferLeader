<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('card_number');
            $table->string('cw2');
            $table->float('balance')->default(0);;
            $table->date('issue_to');
            $table->integer('user_id')->unsigned()->nullable()->references('id')->on('users')->onDelete('set null');
            $table->integer('currency_id')->unsigned()->references('id')->on('currencies');
            $table->integer('deleted')->default(0);
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
        Schema::dropIfExists('cards');
    }
}
