<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMessagePrint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('line_user_message', function (Blueprint $table) {
            $table->integer('print_type')->default(0)->after('type')->comment('0: 不須印, 1: 需印, 2: 印完畢');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('line_user_message', function (Blueprint $table) {
            $table->dropColumn('print_type');
        });
    }
}
