<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetDashboardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_dashboard', function (Blueprint $table) {
            $table->string('id', 25);

            $table->string('code', 25)->nullable();
            $table->float('oil_bopd')->nullable();
            $table->float('gas_mmscfd')->nullable();
            $table->float('total_mboepd')->nullable();
            $table->float('wi_mboepd')->nullable();

            $table->string('created_by', 25)->nullable();
            $table->string('updated_by', 25)->nullable();
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
        Schema::dropIfExists('budget_dashboard');
    }
}
