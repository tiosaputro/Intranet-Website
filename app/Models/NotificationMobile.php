<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationMobile extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "notification_mobile";

    protected $fillable = [
        'id',
        'content_id',
        'category',
        'title',
        'path',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'author_by',
    ];
    //author
    public function author()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

}
