<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateTrackingLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('prtracking_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('runtime_message_id')->unique()->nullable();
            $table->string('message_id')->unique()->nullable();
            $table->integer('customer_id')->unsigned(); // deliberate redundant for quick retrieving
            $table->integer('sending_server_id')->unsigned();
            $table->integer('prcampaign_id')->unsigned(); // deliberate redundant for quick retrieving
            $table->integer('prsubscriber_id')->unsigned(); // deliberate redundant for quick retrieving
            $table->string('status');
            $table->string('error')->nullable();

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
        Schema::drop('prtracking_logs');
    }
}
