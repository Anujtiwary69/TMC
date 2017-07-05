<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrCreateBounceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prbounce_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('runtime_message_id')->nullable();
            $table->string('message_id')->nullable();
            $table->string('bounce_type');
            $table->text('raw');

            $table->timestamps();

            // không cần ràng buộc này, vì thậm chí khi gửi bằng AWS thì SNS bounce gần như ngay lập tức, trước khi ghi xuống tracking_logs
            // $table->foreign('message_id')->references('message_id')->on('tracking_logs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prbounce_logs');
    }
}
