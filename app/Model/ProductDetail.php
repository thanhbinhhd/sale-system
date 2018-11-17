<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    //
    protected $fillable = [
        'size', 'color', 'product_id'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
