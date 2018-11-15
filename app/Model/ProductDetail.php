<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    //
    protected $fillable = [
        'cpu', 'ram', 'screen', 'storage', 'exten_memory',
        'cam1', 'cam2', 'sim', 'connect', 'pin', 'os',
        'note', 'product_id'
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
