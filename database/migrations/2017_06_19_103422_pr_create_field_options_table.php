<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateFieldOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prfield_options', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uid');
            $table->integer('prfield_id')->unsigned();
            $table->string('label');
            $table->string('value');

            $table->timestamps();

            // foreign
            // $table->foreign('prfield_id')->references('id')->on('prfields')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prfield_options');
    }
}
