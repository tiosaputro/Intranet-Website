<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserTokenExpo extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = "users_token_expo";

    protected $fillable = [
        'id',
        'user_id',
        'expo_token',
        'created_at',
        'updated_at'
    ];

    //has one user
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

}
