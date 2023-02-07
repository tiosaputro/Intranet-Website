<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMenuPermission extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "role_menu_permissions";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'role_id',
        'menu_id',
        'permission_slug',
        'created_by',
        'updated_by',
        'updated_at',
        'created_at',
    ];

    public function hasRole(){
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
