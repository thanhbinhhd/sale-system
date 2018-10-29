<?php

namespace App\Repositories;

use App\Model\Image;

class ImageRepository
{
    use BaseRepository;

    protected $model;


    public function __construct(Image $image)
    {
        $this->model = $image;

    }
}