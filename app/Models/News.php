<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "news"; //menu / modul

    protected $fillable = [
        'id',
        'title',
        'content',
        'meta_tags',
        'banner_path',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'active',
        'category'
    ];
    //has one author
    public function creator(){
        return $this->hasOne('App\Models\User','id','created_by');
    }
    //has one updater
    public function updater(){
        return $this->hasOne('App\Models\User','id','updated_by');
    }
}
