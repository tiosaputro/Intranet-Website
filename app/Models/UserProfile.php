<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'user_profile';

    protected $fillable = [
        'id', 'user_id', 'profile_detail',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'path_photo',
        'phone',
        'user_email'
    ];
}
