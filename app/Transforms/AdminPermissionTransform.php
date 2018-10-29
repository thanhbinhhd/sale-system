<?php

namespace App\Transformers;

use App\Model\AdminPermission;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class AdminPermissionTransform extends TransformerAbstract
{
    public function transform(AdminPermission $permission)
    {
        return [

        ];
    }
}
