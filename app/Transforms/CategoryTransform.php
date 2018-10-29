<?php

namespace App\Transformers;

use App\Model\Category;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class CategoryTransform extends TransformerAbstract
{
    public function transform(Category $category)
    {
        return [

        ];
    }
}
