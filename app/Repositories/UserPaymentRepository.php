<?php

namespace App\Repositories;

use App\Model\UserPayment;

class UserPaymentRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(UserPayment $payment)
    {
        $this->model = $payment;

    }
}