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

    public function getNew(){
        return $this->model->where('status',1)->take(8)->get();
    }

    public function getWithCondition($condition, $order){
        return $this->model->where('status',1)->orderBy($condition,$order)->take(8)->get();
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
        $order = $request->get('order');

        $products = $products->select('products.*')->
        join('taggables', 'products.id', '=', 'taggable_id')->
        join('tags', 'tags.id', '=', 'taggables.tag_id')->
        join('product_details', 'products.id', '=', 'product_details.product_id');

        if($maxPrice != null)
            $products = $products->where('price', '<', $maxPrice);
        if($minPrice != null)
            $products = $products->where('price', '>', $minPrice);
        if($keyword != null)
            $products = $products->where('products.name', 'like', '%'. $keyword .'%');
        if($color != null)
            $products = $products->whereIn('color', $color);
        if($tags != null)
            $products = $products->whereIn('tag_id', $tags);
        $products = $products->groupBy('products.id');
        if($order != null){
            if(in_array($order, ['asc', 'desc']))
                $products = $products->orderBy('price', $order);
            elseif($order == 'popular')
                $products = $products->orderBy('number_viewed', 'desc');
        }
        $products = $products->distinct('products.id');
        return $products;
    }
}
