<?php

namespace App\Transformers;

use App\Model\User;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class UserTransform extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [

        ];
    }
}
