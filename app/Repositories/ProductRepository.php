<?php

namespace App\Repositories;

use App\Model\Product;

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
}
