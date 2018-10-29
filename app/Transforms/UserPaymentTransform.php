<?php

namespace App\Transformers;

use App\Model\UserPayment;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class UserPaymentTransform extends TransformerAbstract
{
    public function transform(UserPayment $payment)
    {
        return [

        ];
    }
}
