<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
      'name', 'slug', 'description',
        'quantity', 'review', 'price', 'number_viewed',
        'status', 'category_id', 'admin_id', 'sale', 'image_path'
    ];

    public function admins() {
        return $this->belongsToMany(Admin::class, 'admin_products', 'product_id');
    }

    public function creator(){
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    public function productDetail() {
        return $this->hasOne(ProductDetail::class, 'product_id');
    }

    public function productSales() {
        return $this->hasMany(ProductSale::class, 'product_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function taggables() {
        return $this->morphMany(Taggable::class, 'taggable');
    }
}
