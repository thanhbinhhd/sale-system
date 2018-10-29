<?php

namespace App\Repositories;

use App\Model\Tag;

class TagRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Tag $tag)
    {
        $this->model = $tag;

    }
}