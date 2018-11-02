<?php

namespace App\Transformers;

use App\Model\Admin;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class AdminTransform extends TransformerAbstract
{
    public function transform(Admin $admin)
    {
        return [
            'username' => $admin->username,
            'password' => $admin->password,
            'level' => $admin->level,
            'status' => $admin->status
        ];
    }
}
