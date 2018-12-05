<?php

namespace App\Repositories;

use App\Model\AdminPermission;

class AdminPermissionRepository implements RepositoryInterface
{
    use BaseRepository;

    protected $model;

    public function __construct(AdminPermission $permission)
    {
        $this->model = $permission;

    }
}