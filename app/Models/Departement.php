<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'departements';

    protected $fillable = [
        'id', 'name','descriptions',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
}
