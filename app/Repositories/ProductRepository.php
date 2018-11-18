<?php

namespace App\Repositories;

use App\Model\Product;
use Illuminate\Http\Request;

class ProductRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function updateStatus($status, $id){
        $product = $this->getById($id);
        $product->status = $status;
        $this->update($id,$product->toArray());
        return $status;
    }

    /**
     * @param $product
     * @param Request $request
     * @return mixed
     */
    public function filte($products, Request $request){
        $keyword = $request->get('search-product');
        $tags = $request->get('tag');
        $color = $request->get('color');
        $minPrice = $request->get('price-min');
        $maxPrice = $request->get('price-max');

        $products = $products->select('products.*')->
        join('taggables', 'products.id', '=', 'taggable_id')->
        join('tags', 'tags.id', '=', 'taggables.tag_id')->
        join('product_details', 'products.id', '=', 'product_details.product_id')->
        where('price', '<', $maxPrice)->
        where('price', '>', $minPrice)->
        where('status', Product::ACTIVE);
        if($keyword != null)
            $products = $products->where('products.name', 'like', '%'. $keyword .'%');
        if($color != null)
            $products = $products->whereIn('color', $color);
        if($tags != null)
            $products = $products->whereIn('tag_id', $tags);
        $products = $products->distinct('products.id');
        return $products;
    }
}
