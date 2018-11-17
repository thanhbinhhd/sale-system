<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    const ACTIVE = 1;
    const BLOCKED = 0;
    protected $table = 'news';

    protected $fillable = [
        'title', 'slug', 'author', 'description', 'content',
        'status', 'source', 'admin_id', 'category_id'
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function taggables() {
        return $this->morphMany(Taggable::class, 'taggable');
    }
}
