<?php

namespace App\Repositories;

use App\Model\User;
use Illuminate\Support\Facades\Auth;

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

    public function currentUser(){
        return $user = Auth::guard('user')->user();
    }

    public function updateProfile(User $user){
        $this->update($user->id, $user->toArray());
    }

    public function updatePass(User $user){
        $this->update($user->id, $user->toArray());
    }

}
