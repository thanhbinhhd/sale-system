<?php

namespace App\Transformers;

use App\Model\ProductDetail;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ProductDetailTransform extends TransformerAbstract
{
    public function transform(ProductDetail $detail)
    {
        return [

        ];
    }
}
