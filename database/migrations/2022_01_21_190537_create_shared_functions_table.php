<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_functions', function (Blueprint $table) {
            $table->string('id', 25);
            $table->text('name')->nullable();
            $table->text('keterangan')->nullable();

            $table->string('created_by', 25);
            $table->string('updated_by', 25);
            $table->boolean('active');
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
        Schema::dropIfExists('shared_functions');
    }
}
