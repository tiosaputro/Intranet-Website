<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->string('id', 25);

            $table->string('category', 100)->nullable(); //policy, form, reference
            $table->text('name')->nullable();
            $table->text('title')->nullable();
            $table->text('category_libraries')->nullable();
            $table->text('sop_number')->nullable();
            $table->string('rev_no',10)->nullable();
            $table->date('issued')->nullable();
            $table->date('expired')->nullable();
            $table->string('status', '20')->nullable(); //updated, expired
            $table->text('devision_owner')->nullable();
            $table->text('remark')->nullable();
            $table->string('business_unit_id', 25);
            $table->text('location')->nullable();
            $table->string('shared_function_id', 25);
            $table->text('file_path')->nullable();

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
        Schema::dropIfExists('libraries');
    }
}
