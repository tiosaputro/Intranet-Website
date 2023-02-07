<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otp_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id', 50)->nullable();
            $table->string('application_name', 150)->nullable();
            $table->string('path', 250)->nullable();
            $table->string('otp', 6)->nullable(); //code otp
            $table->string('email', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('status', 10)->comment('send, valid');
            //browser
            $table->boolean('is_mobile')->default(false)->nullable();
            $table->string('device_name', 100)->nullable();
            $table->string('device_platform', 100)->nullable();
            $table->ipAddress('ip_address')->nullable();
            //expired at
            $table->timestamp('expired_date')->nullable();
            $table->timestamp('expired_otp')->nullable();
            $table->string('created_by', 25)->nullable();
            $table->string('updated_by', 25)->nullable();
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
        Schema::dropIfExists('otp_user');
    }
}
