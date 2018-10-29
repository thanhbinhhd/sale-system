<?php

namespace App\Repositories;

use App\Model\News;

class NewsRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(News $news)
    {
        $this->model = $news;
    }
}