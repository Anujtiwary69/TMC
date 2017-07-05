<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('prfields', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uid');
            $table->integer('pr_list_id')->unsigned();
            $table->string('label');
            $table->string('type');
            $table->string('tag');
            $table->string('default_value')->nullable();
            $table->boolean('visible');
            $table->boolean('required');
            $table->integer('custom_order');

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
        Schema::drop('prfields');
    }
}
