<?php

namespace App\Transformers;

use App\Model\Tag;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class TagTransform extends TransformerAbstract
{
    public function transform(Tag $tag)
    {
        return [

        ];
    }
}
