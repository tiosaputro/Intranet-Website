<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "broadcast";

    protected $fillable = [
        'id',
        'title',
        'content',
        'file_path',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'active',
        'type',
        'is_notif_mobile',
        'is_recurrence',
        'duration',
        'cron_active',
        'date_cron_active'
    ];
    //has one author
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
    //has one updater
    public function updater()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}
