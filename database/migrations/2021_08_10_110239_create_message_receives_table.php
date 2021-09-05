<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageReceivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_receives', function (Blueprint $table) {
            $table->increments('receive_id');
            $table->bigInteger('message_id');
            $table->string('user_uuid', 40);
            $table->string('message_type', 10);
            $table->text('message_content');
            $table->string('reply_token', 40)->nullable();
            $table->datetime('send_at');
            $table->datetime('receive_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_receives');
    }
}
