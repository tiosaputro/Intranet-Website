<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsparentToMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->string('is_parent', 25)->nullable()->default('#');
            $table->string('order', 10)->nullable();
            $table->string('url', 255)->nullable();
            $table->string('icon', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->dropColumn('is_parent');
            $table->dropColumn('order');
            $table->dropColumn('url');
            $table->dropColumn('icon');
        });
    }
}
