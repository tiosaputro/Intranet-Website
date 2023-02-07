<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryFile extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "gallery_file";
    protected $casts = [
        'id' => 'string',
        'gallery_folder_id' => 'string'
    ];
    protected $keyType = 'string';
    protected $foreignKey = 'gallery_folder_id';
    protected $fillable = [
        'ID',
        'GALLERY_FOLDER_ID',
        'PATH_FILE',
        'NAME_FILE',
        'DESCRIPTION_FILE',
        'SIZE_FILE',
        'TYPE_FILE',
        'EXT_FILE',
        'TOTAL_VIEWER_FILE',
        'CREATED_AT',
        'CREATED_BY',
        'UPDATED_AT',
        'UPDATED_BY',
        'DELETED_AT',
        'DELETED_BY',
        'IS_PUBLIC'
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
    //has one folder
    public function fileFolder(){
        return $this->hasOne('App\Models\GalleryFolder','id','gallery_folder_id');
    }
    public function hasFolder(){
        //set relation
        return $this->fileFolder()->where('gallery_file.gallery_folder_id', 'not like', "%uncategorized%");
    }
}
