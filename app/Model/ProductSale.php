<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    //
    protected $fillable = [
        'description', 'product_id', 'promo',
        'promo_code', 'type', 'admin_id', 'start_date', 'end_date'
    ];

    protected $dates = [
        'start_date', 'end_date'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
