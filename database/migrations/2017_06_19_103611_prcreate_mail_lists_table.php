<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrcreateMailListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('pr_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uid');
            $table->integer('customer_id')->unsigned();
            $table->integer('contact_id')->unsigned();
            $table->string('name');
            $table->string('default_subject');
            $table->string('from_email')->nullable();
            $table->string('from_name')->nullable();
            $table->text('description')->nullable();
            $table->text('pr_subscribe')->nullable();
            $table->text('pr_unsubscribe')->nullable();
            $table->text('pr_daily')->nullable();
            $table->boolean('send_welcome_email')->default(false);
            $table->boolean('unsubscribe_notification')->default(false);
            $table->string('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('pr_lists');
    }
}
