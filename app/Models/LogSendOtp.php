<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSendOtp extends Model
{
    use HasFactory;
    public $incrementing = true;
    protected $primaryKey = "id";
    protected $table="log_send_otp";
    //fillabe
    protected $fillable = [
        'id',
        'otp_user_id',
        'via',
        'status',
        'code',
        'is_mobile',
        'device_name',
        'device_platform',
        'user_agent',
        'ip_address',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

}
