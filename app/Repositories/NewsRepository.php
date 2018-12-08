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

    public function getNew(){
        $news = $this->model->where('status',1)->take(3)->get();
        return $news;
    }

    public function getBySlug($blogSlug){
        return $this->model->where('slug', $blogSlug)->first();
    }
}
