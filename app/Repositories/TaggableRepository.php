<?php

namespace App\Repositories;

use App\Model\Taggable;

class TaggableRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Taggable $taggable)
    {
        $this->model = $taggable;

    }
}
