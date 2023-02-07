<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content', function (Blueprint $table) {
            $table->string('id',25);
            $table->string('content_category_id',25);
            $table->text('author')->nullable();
            $table->text('title')->nullable();
            $table->text('content')->nullable();
            $table->text('source')->nullable();
            $table->text('path_file')->nullable();
            $table->text('meta_tags')->nullable();
            $table->text('active')->default(1);
            $table->string('created_by', 25); //is author
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
        Schema::dropIfExists('content');
    }
}
