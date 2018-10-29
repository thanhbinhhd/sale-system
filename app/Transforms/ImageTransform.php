<?php

namespace App\Transformers;

use App\Model\Image;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ImageTransform extends TransformerAbstract
{
    public function transform(Image $image)
    {
        return [

        ];
    }
}
