<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateCampaignsListsSegmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prcampaigns_lists_segments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prcampaign_id')->unsigned();
            $table->integer('pr_list_id')->unsigned();
            $table->integer('prsegment_id')->unsigned()->nullable();
            $table->timestamps();
            
            // $table->foreign('prcampaign_id')->references('id')->on('prcampaigns')->onDelete('cascade');
            // $table->foreign('pr_list_id')->references('id')->on('pr_lists')->onDelete('cascade');
            // $table->foreign('prsegment_id')->references('id')->on('prsegments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prcampaigns_lists_segments');
    }
}
