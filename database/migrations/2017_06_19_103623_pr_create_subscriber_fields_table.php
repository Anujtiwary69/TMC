<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateSubscriberFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prsubscriber_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prsubscriber_id')->unsigned();
            $table->integer('prfield_id')->unsigned();
            $table->text('value');

            $table->timestamps();

            // foreign
            $table->foreign('prsubscriber_id')->references('id')->on('prsubscribers')->onDelete('cascade');
            $table->foreign('prfield_id')->references('id')->on('prfields')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prsubscriber_fields');
    }
}
