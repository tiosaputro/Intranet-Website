<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePermissionRoleIdFromMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Menu', function (Blueprint $table) {
            //
            $table->dropColumn('permission_role_id');
            $table->dropColumn('is_parent');

            $table->string('slug', 30);

            $table->string('created_by', 25);
            $table->string('updated_by', 25);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Menu', function (Blueprint $table) {
            //
            $table->string('permission_role_id');
            $table->string('is_parent');

            $table->dropColumn('slug');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
}
