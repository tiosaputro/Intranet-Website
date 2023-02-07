<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleMenuPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_menu_permissions', function (Blueprint $table) {
            $table->string('id', 25);
            $table->bigIncrements('role_id');
            $table->string('menu_id',25);
            $table->text('permission_slug');
            $table->string('created_by', 25);
            $table->string('updated_by', 25)->nullable();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('menu_id')->references('id')->on('menu');
            $table->primary('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_menu_permissions');
    }
}
