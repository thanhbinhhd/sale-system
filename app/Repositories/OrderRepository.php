<?php

namespace App\Repositories;

use App\Model\Order;

class OrderRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Order $order)
    {
        $this->model = $order;

    }
}