<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directories', function (Blueprint $table) {
            $table->string('id', 25);

            $table->string('category',50)->nullable(); //emergency, extension
            $table->text('name')->nullable();
            $table->text('departement')->nullable();
            $table->text('lantai')->nullable();
            $table->text('ext')->nullable();
            $table->text('phone')->nullable();
            $table->text('position')->nullable();
            $table->text('photo_path')->nullable();

            $table->string('created_by', 25);
            $table->string('updated_by', 25);
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('directories');
    }
}
