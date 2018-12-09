<?php

namespace App\Repositories;

use App\Model\Subcribe;

class SubscribeRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Subcribe $subscribe) {
        $this->model = $subscribe;
    }

}
