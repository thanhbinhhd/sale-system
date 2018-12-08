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

    public function updateStatus($status, $id){
        $blog = $this->getById($id);
        $blog->status = $status;
        $this->update($id,$blog->toArray());
        return $status;
    }

    public function getIDfromSlug($slug) {
        $new = $this->model->where('slug', $slug)->first();
        return $new->id;
    }

    public function getBySlug($blogSlug){
        return $this->model->where('slug', $blogSlug)->first();
    }
}
