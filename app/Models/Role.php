<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public $incrementing = true;
    protected $table = "roles";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'slug',
        'guard_name',
        'name',
        'created_by',
        'updated_by',
        'updated_at',
        'created_at',
    ];

    //has many to many relationship
    public function hasRoleMenuPermission(){
        return $this->hasMany('App\Models\RoleMenuPermission', 'role_id', 'id');
    }
    public function hasUserRole(){
        return $this->hasMany('App\Models\UserRole', 'role_id', 'id');
    }
}
