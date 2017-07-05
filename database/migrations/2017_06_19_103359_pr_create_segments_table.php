<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateSegmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('prsegments', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uid');
            $table->integer('pr_list_id')->unsigned();
            $table->string('name');
            $table->string('matching');

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
        Schema::drop('prsegments');
    }
}
