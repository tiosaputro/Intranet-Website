<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgeSharingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('knowledge_sharing', function (Blueprint $table) {
            $table->string('id', 25);

            $table->string('departement_id',25);
            $table->text('title');
            $table->text('path_file')->nullable();
            $table->text('banner_path')->nullable();
            $table->text('content')->nullable();
            $table->text('author')->nullable();
            $table->text('photo_author')->nullable();
            $table->text('meta_tags')->nullable();

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
        Schema::dropIfExists('knowledge_sharing');
    }
}
