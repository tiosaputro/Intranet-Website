<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    public $incrementing = true;
    protected $table = "permissions";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'name',
        'guard_name',
        'active',
        'created_by',
        'updated_by',
        'updated_at',
        'created_at',
    ];
}
