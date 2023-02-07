<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogSendOtpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_send_otp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('otp_user_id', 100);
            //reference user_id to user_id otp_user
            $table->string('via', 50)->nullable();
            $table->string('status', 10)->comment('error or success');
            $table->string('code', 10)->nullable();

            $table->boolean('is_mobile')->default(false)->nullable();
            $table->string('device_name', 100)->nullable();
            $table->string('device_platform', 100)->nullable();
            $table->text('user_agent')->nullable();
            $table->ipAddress('ip_address')->nullable();

            $table->string('created_by', 150)->nullable();
            $table->string('updated_by', 150)->nullable();
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
        Schema::dropIfExists('log_send_otp');
    }
}
