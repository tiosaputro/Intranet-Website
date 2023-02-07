<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'dashboard';
    protected $fillable = [
        'id',
        'created_at',
        'code',
        'gross_oil_bopd',
        'gross_gas_mmscfd',
        'gross_gas_boepd',
        'gross_total_mboepd',
        'wi_oil_bopd',
        'wi_gas_mmscfd',
        'wi_gas_boepd',
        'wi_total_mboepd',
        'wi_mboepd',
        'created_by',
        'updated_by',
        'updated_at'
    ];

    //relation author
    public function author()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'created_by');
    }
    public function editor()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'updated_by');
    }

}
