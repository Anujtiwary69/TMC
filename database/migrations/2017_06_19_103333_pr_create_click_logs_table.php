<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateClickLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('prclick_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message_id');
            $table->string('url');
            $table->string('ip_address');
            $table->text('user_agent');

            $table->timestamps();

            // foreign
            $table->foreign('message_id')->references('message_id')->on('prtracking_logs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prclick_logs');
    }
}
