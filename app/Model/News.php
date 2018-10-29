<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    protected $table = 'news';

    protected $fillable = [
        'title', 'slug', 'author', 'description', 'content',
        'status', 'source', 'admin_id', 'user_id', 'category_id'
    ];
}
