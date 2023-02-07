<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpUser extends Model
{
    use HasFactory;
    public $incrementing = true;
    protected $primaryKey = "id";
    protected $table = "otp_user";
    //fillabe
    protected $fillable = [
        'id',
        'user_id',
        'application_name',
        'path',
        'otp',
        'email',
        'phone',
        'status',
        'is_mobile',
        'device_name',
        'device_platform',
        'ip_address',
        'expired_date',
        'expired_otp',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

}
