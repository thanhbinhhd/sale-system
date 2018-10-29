<?php

namespace App\Repositories;

use App\Model\Policy;

class PolicyRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Policy $policy)
    {
        $this->model = $policy;
    }
}