<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateAutomationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('prautomations', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uid');
            $table->integer('customer_id')->unsigned();
            $table->integer('pr_list_id')->unsigned()->nullable();
            $table->integer('prsegment_id')->unsigned()->nullable();
            $table->text('name');
            $table->integer('custom_order');
            $table->string('status');
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('pr_list_id')->references('id')->on('pr_lists')->onDelete('cascade');
            $table->foreign('prsegment_id')->references('id')->on('prsegments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prautomations');
    }
}
