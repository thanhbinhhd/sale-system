<?php

namespace App\Transformers;

use App\Model\News;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class NewsTransform extends TransformerAbstract
{
    public function transform(News $news)
    {
        return [

        ];
    }
}
