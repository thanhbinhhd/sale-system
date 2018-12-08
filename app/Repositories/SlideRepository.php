<?php

namespace App\Repositories;

use App\Model\Slide;

class SlideRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Slide $slide)
    {
        $this->model = $slide;
    }

    public function updateStatus($status, $id){
        $slide = $this->getById($id);
        $slide->status = $status;
        $this->update($id,$slide->toArray());
        return $status;
    }
}