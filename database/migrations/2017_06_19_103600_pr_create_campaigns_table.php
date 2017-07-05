<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prcampaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uid');
            $table->integer('customer_id')->unsigned();
            $table->integer('pr_list_id')->unsigned()->nullable();
            $table->integer('segment_id')->unsigned()->nullable();
            $table->text('type');
            $table->text('name');
            $table->text('subject');
            $table->longtext('html');
            $table->longtext('plain');
            $table->text('from_email');
            $table->text('from_name');
            $table->text('reply_to');
            $table->text('status');
            $table->boolean('sign_dkim');
            $table->boolean('track_open');
            $table->boolean('track_click');
            $table->integer('resend');
            $table->integer('custom_order');
            $table->timestamp('run_at')->nullable();
            $table->timestamp('delivery_at')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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
        Schema::drop('prcampaigns');
    }
}
