<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateFeedbackLoopHandlersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prfeedback_loop_handlers', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uid');
            $table->integer('admin_id')->unsigned();
            $table->string('name');
            $table->string('type');
            $table->string('host');
            $table->string('username');
            $table->string('password');
            $table->string('port');
            $table->string('protocol');
            $table->string('encryption');
            $table->string('status');
            $table->integer('custom_order');

            $table->timestamps();

            // foreign
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::drop('prfeedback_loop_handlers');
    }
}
