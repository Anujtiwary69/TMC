<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateAutoCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('prauto_campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prauto_event_id')->unsigned();
            $table->integer('prcampaign_id')->unsigned();
            
            $table->timestamps();
            
            $table->foreign('prauto_event_id')->references('id')->on('prauto_events')->onDelete('cascade');
            $table->foreign('prcampaign_id')->references('id')->on('prcampaigns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prauto_campaigns');
    }
}
