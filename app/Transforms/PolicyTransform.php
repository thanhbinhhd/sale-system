<?php

namespace App\Transformers;

use App\Model\Policy;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class PolicyTransform extends TransformerAbstract
{
    public function transform(Policy $policy)
    {
        return [

        ];
    }
}
