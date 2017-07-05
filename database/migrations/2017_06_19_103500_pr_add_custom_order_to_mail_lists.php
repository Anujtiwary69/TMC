<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrAddCustomOrderToMailLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('pr_lists', function (Blueprint $table) {
            $table->integer('custom_order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('pr_lists', function (Blueprint $table) {
            $table->dropColumn('custom_order');
        });
    }
}
