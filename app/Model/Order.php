<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
      'user_id', 'quantity', 'sub_total',
        'total', 'status', 'note'
    ];
}
