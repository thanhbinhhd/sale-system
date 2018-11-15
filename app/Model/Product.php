<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
      'name', 'slug', 'description',
        'quantity', 'review', 'price', 'number_viewed',
        'status', 'category_id'
    ];


}
