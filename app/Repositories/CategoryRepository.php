<?php

namespace App\Repositories;

use App\Model\Category;

class CategoryRepository
{
    use BaseRepository;

    const ALL = 'All';

    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function getNew(){
        return $this->model->take(config('sales.number_category_get'))->get();
    }

}
