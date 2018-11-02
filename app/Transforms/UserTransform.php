<?php

namespace App\Transformers;

use App\Model\User;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class UserTransform extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'email_verified_at' => $user->email_verified_at,
            'phone_number' => $user->phone_number,
            'address' => $user->address,
            'avatar' => $user->avatar,
            'status' => $user->status,
            'description' => $user->description,
            'email_notify_enabled' => $user->email_notify_enabled
        ];
    }
}
