<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    protected $fillable = [
        'product_id', 'quantity', 'order_id', 'total_price'
    ];
}
