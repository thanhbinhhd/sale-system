<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    //
    protected $fillable = [
        'social_id', 'access_token', 'refresh_token', 'providers'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
