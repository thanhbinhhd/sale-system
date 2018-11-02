<?php

namespace App\Repositories;

use App\Model\User;

class UserRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;

    }

    public function updateStatus($status, $id){
        $user = $this->getById($id);
        $user->status = $status;
        $this->update($id,$user->toArray());
        return $status;
    }


}
