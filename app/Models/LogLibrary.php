<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogLibrary extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "log_libraries";

    protected $fillable = [
        'id','category','name','title','category_libraries','sop_number','rev_no','issued','expired','status', 'devision_owner',
        'remark', 'business_unit_id', 'location', 'shared_function_id', 'file_path', 'ext_file', 'tags_relation', 'libraries_id','keterangan',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by',
        'active'
    ];

    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
    public function updater(){
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
    public function deleter(){
        return $this->hasOne('App\Models\User','id', 'deleted_by');
    }
    public function business_unit(){
        return $this->hasOne('App\Models\BusinessUnit','id', 'business_unit_id');
    }
    public function shared_function(){
        return $this->hasOne('App\Models\SharedFunction','id', 'shared_function_id');
    }
    public function department(){
        return $this->hasOne('App\Models\Departement','id', 'devision_owner');
    }
    public function library(){
        //belongs to library
        return $this->belongsToMany('App\Models\Library');
    }
}
