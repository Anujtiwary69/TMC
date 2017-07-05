<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateAutoEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prauto_events', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uid');
            $table->integer('prautomation_id')->unsigned();
            $table->string('event_type');
            $table->text('data');
            $table->integer('previous_event_id')->unsigned()->nullable();
            $table->integer('custom_order');

            $table->timestamps();
            
            $table->foreign('prautomation_id')->references('id')->on('prautomations')->onDelete('cascade');
            $table->foreign('previous_event_id')->references('id')->on('prauto_events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prauto_events');
    }
}
