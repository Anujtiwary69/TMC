<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrAddTemplateSourceToCampaigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prcampaigns', function (Blueprint $table) {
            $table->string('prtemplate_source');
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
            $table->dropColumn('prtemplate_source');
        });
    }
}
