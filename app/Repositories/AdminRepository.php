<?php

namespace App\Repositories;

use App\Model\Admin;

class AdminRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Admin $admin)
    {
        $this->model = $admin;

    }
}