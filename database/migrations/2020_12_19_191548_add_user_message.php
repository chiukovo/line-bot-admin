<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_user_message', function (Blueprint $table) {
            $table->id();
            $table->string('group_id');
            $table->string('user_id');
            $table->integer('type')->default(0)->comment('0: 訊息, 1: 圖片');
            $table->text('msg');
            $table->string('picture_url')->nullable();
            $table->string('date');
            $table->index(['group_id', 'user_id', 'date']);
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
        Schema::dropIfExists('line_user_message');
    }
}
