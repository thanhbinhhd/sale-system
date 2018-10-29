<?php

namespace App\Transformers;

use App\Model\Order;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class OrderTransform extends TransformerAbstract
{
    public function transform(Order $order)
    {
        return [

        ];
    }
}
