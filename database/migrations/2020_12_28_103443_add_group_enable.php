<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupEnable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('line_group', function (Blueprint $table) {
            $table->integer('print_open')->default(0)->after('picture_url')->comment('0: close, 1: open');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('line_group', function (Blueprint $table) {
            $table->dropColumn('print_open');
        });
    }
}
