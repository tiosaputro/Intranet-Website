<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeSharing extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'knowledge_sharing';

    protected $fillable = [
        'id',
        'departement_id',
        'title',
        'meta_tags',
        'content',
        'path_file',
        'banner_path',
        'author',
        'photo_author',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'active'
    ];
}
