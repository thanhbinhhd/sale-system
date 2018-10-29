<?php

namespace App\Transformers;

use App\Model\Product;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ProductTransform extends TransformerAbstract
{
    public function transform(Product $product)
    {
        return [

        ];
    }
}
