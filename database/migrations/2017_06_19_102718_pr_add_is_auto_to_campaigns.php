<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrAddIsAutoToCampaigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prcampaigns', function (Blueprint $table) {
            $table->boolean('is_auto')->default(false);
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
            $table->dropColumn('is_auto');
        });
    }
}
