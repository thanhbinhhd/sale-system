<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $fillable = [
      'image_url', 'imageable_id', 'imageable_type'
    ];
}
