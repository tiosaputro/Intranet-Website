<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetDashboard extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'budget_dashboard';

    protected $fillable = [
        'id',
        'code',
        'oil_bopd',
        'gas_mmscfd',
        'total_mboepd',
        'wi_mboepd',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
}
