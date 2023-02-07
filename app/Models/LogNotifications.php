<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogNotifications extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "log_notifications";

    protected $fillable = [
        'id',
        'status',
        'responses',
        'expo_token',
        'data',
        'title',
        'body',
        'notif_id',
        'created_at',
        'updated_at'
    ];

}
