<?php

namespace App\Repositories;

use App\Model\ProductDetail;

class ProductDetailRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(ProductDetail $detail)
    {
        $this->model = $detail;
    }

}
