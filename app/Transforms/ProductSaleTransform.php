<?php

namespace App\Transformers;

use App\Model\ProductSale;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ProductSaleTransform extends TransformerAbstract
{
    public function transform(ProductSale $sale)
    {
        return [

        ];
    }
}
