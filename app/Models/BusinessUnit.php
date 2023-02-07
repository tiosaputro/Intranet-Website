<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'business_units';
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

    public static function getOption(){
        $get = BusinessUnit::where('active', 1)->get();
        return $get->map(function($row){
            return [
                'id' => $row->id,
                'text' => $row->name
            ];
        });
    }

}
