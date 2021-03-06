<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrAddCampaignsLastErrorField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prcampaigns', function (Blueprint $table) {
            $table->text('last_error')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('prcampaigns', function (Blueprint $table) {
            $table->dropColumn('last_error');
        });
    }
}
