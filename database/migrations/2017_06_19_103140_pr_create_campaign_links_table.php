<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateCampaignLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prcampaign_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prcampaign_id')->unsigned();
            $table->integer('prlink_id')->unsigned();

            $table->timestamps();

            // foreign
            // $table->foreign('prcampaign_id')->references('id')->on('prcampaigns')->onDelete('cascade');
            // $table->foreign('prlink_id')->references('id')->on('prlinks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prcampaign_links');
    }
}
