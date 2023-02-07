<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasRoles extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "model_has_roles";
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'role_id',
        'model_type',
        'model_id'
    ];
}
