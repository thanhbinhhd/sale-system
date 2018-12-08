<?php

namespace App\Repositories;

use App\Model\ProductSale;

class ProductSaleRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(ProductSale $sale)
    {
        $this->model = $sale;

    }
}
