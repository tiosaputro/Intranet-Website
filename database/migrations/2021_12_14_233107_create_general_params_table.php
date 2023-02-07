<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_params', function (Blueprint $table) {
            $table->string('id',25);
            $table->text('slug');
            $table->text('name');
            $table->text('descriptions');
            $table->string('created_by', 25);
            $table->string('updated_by', 25);
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
        Schema::dropIfExists('general_params');
    }
}
