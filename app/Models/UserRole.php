<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "user_roles";
    protected $fillable = [
        'id',
        'user_id',
        'role_id',
        'created_by',
        'updated_by',
    ];

    public function hasRole(){
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }
}
