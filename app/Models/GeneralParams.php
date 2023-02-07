<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralParams extends Model
{
    use HasFactory;
    public $incrementing = true;
    protected $table = "general_params";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'slug',
        'name',
        'descriptions',
        'created_by',
        'updated_by',
        'updated_at',
        'created_at',
    ];

    public static function getArray($slug)
    {
        $data = GeneralParams::where('slug', 'LIKE', '%' . $slug . '%')->first();
        if (!empty($data)) {
            $value = $data->name;
            return json_decode($value, 1);
        }
        return [];
    }
}
