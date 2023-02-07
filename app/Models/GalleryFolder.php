<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryFolder extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "gallery_folder";
    protected $casts = [
        'id' => 'string',
    ];
    protected $keyType = 'string';
    protected $fillable = [
        'ID',
        'NAME_FOLDER',
        'DESCRIPTION_FOLDER',
        'SIZE_FOLDER',
        'IS_PUBLIC',
        'IS_IMPORTANT',
        'TOTAL_VIEWER',
        'PATH_FOLDER',
        'CREATED_AT',
        'CREATED_BY',
        'UPDATED_AT',
        'UPDATED_BY',
        'DELETED_AT',
        'DELETED_BY'
    ];
    //has one author
    public function creator(){
        return $this->hasOne('App\Models\User','id','created_by');
    }
    //has one updater
    public function updater(){
        return $this->hasOne('App\Models\User','id','updated_by');
    }
    //has one deleter
    public function deleter(){
        return $this->hasOne('App\Models\User','id','deleted_by');
    }
    //has many files to gallery file
    public function folderFile(){
        //set relation
        return $this->hasMany('App\Models\GalleryFile','gallery_folder_id','id');
    }
    public function hasFiles(){
        //set relation
        return $this->folderFile()->where('gallery_file.gallery_folder_id', 'not like', "%uncategorized%")->where('gallery_file.deleted_at', null);
    }
}
