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

    public function updateStatus($status, $id){
        $product = $this->getById($id);
        $product->status = $status;
        $this->update($id,$product->toArray());
        return $status;
    }
}
