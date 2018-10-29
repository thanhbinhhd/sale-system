<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    //
    protected $fillable = [
        'description', 'product_id', 'promo',
        'promo_code', 'type', 'start_date', 'end_date'
    ];
}
