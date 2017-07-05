<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrAddSubscribeConfirmationToMailLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pr_lists', function (Blueprint $table) {
            $table->boolean('prsubscribe_confirmation')->default(true);
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
            $table->dropColumn('prsubscribe_confirmation');
        });
    }
}
