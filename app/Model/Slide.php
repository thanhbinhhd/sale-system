<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    //
    protected $fillable = [
      'title', 'link', 'status'
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
