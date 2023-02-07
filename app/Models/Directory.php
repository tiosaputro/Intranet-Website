<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Directory extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "directories";

    protected $fillable = [
        'id','category','name','departement','lantai','ext','phone','position','photo_path',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'active',
        'division',
        'location'
    ];

    public static function upsertExtension($name, $dataAD){
        $model = Directory::where('category', 'extension')->where('name','like', '%'.$name.'%')->first();
        if(empty($model)){
            $model = new Directory();
            $model->id = generate_id();
            $model->created_at = now();
        }
        $model->name = $name;
        $model->category = 'extension';
        $model->departement = $dataAD['department'];
        $model->lantai = $dataAD['physicaldeliveryofficename'];
        $model->ext = $dataAD['telephonenumber'];
        $model->phone = '-';
        $model->position = $dataAD['extensionattribute12'];
        $model->created_by = Auth::user()->id;
        $model->updated_by = Auth::user()->id;
        $model->updated_at = now();
        $model->active = 1;
        $model->save();
    }
}
