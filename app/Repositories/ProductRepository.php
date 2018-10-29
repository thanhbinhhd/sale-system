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
}