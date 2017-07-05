<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('prsubscribers', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uid');
            $table->integer('pr_list_id')->unsigned();
            $table->string('email');
            $table->string('status');
            $table->string('from');
            $table->string('ip');

            $table->timestamps();

            // foreign
            $table->foreign('pr_list_id')->references('id')->on('pr_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('prsubscribers');
    }
}
