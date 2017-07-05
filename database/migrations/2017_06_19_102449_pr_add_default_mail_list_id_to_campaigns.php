<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrAddDefaultMailListIdToCampaigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prcampaigns', function (Blueprint $table) {
            $table->integer('default_pr_list_id')->unsigned()->nullable();
            
            $table->foreign('default_pr_list_id')->references('id')->on('pr_lists')->onDelete('cascade');
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
            $table->dropForeign('prcampaigns_default_pr_list_id_foreign');
            $table->dropColumn('prdefault_pr_list_id');
        });
    }
}
