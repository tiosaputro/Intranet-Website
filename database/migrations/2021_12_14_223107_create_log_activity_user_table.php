<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogActivityUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_activity_user', function (Blueprint $table) {
            $table->string('id',25);
            $table->string('user_id',25);
            $table->text('program_name');
            $table->text('route');
            $table->text('descriptions');
            $table->string('created_by', 25);
            $table->string('updated_by', 25);
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_activity_user');
    }
}
