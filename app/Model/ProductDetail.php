<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    //
    protected $fillable = [
        'cpu', 'ram', 'screen', 'storage', 'exten_memory',
        'cam1', 'cam2', 'sim', 'connect', 'pin', 'os',
        'note', 'product_id'
    ];
}
