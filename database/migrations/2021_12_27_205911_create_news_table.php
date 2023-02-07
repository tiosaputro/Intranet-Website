<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->string('id', 25);
            $table->text('title');
            $table->text('content')->nullable();
            $table->text('meta_tags')->nullable();
            $table->text('banner_path')->nullable();
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
        Schema::dropIfExists('news');
    }
}
