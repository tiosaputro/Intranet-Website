<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedFunction extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'shared_functions';
    protected $fillable = [
        'id',
        'name',
        'keterangan',
        'active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
