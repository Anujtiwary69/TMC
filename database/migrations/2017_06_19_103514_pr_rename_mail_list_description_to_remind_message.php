<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrRenameMailListDescriptionToRemindMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('pr_lists', function (Blueprint $table) {
            $table->renameColumn('description', 'remind_message');
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
            $table->renameColumn('remind_message', 'description');
        });
    }
}
