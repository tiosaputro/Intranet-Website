<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'calendar';

    protected $fillable = [
        'ID',
        'URL',
        'TITLE',
        'START_DATE',
        'END_DATE',
        'ALLDAY',
        'CATEGORY',
        'GUEST',
        'LOCATION',
        'DESCRIPTION',
        'CREATED_AT',
        'UPDATED_AT',
        'CREATED_BY',
        'UPDATED_BY',
        'DELETED_AT',
        'DELETED_BY',
        'STATUS',
        'REPEAT',
        'BANNER'
    ];

    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
    public function updater()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
    public function deleter()
    {
        return $this->hasOne('App\Models\User', 'id', 'deleted_by');
    }
}
