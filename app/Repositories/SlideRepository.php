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
}