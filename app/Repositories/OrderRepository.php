<?php

namespace App\Repositories;

use App\Model\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository
{

    use BaseRepository;

    protected $model;

    const YEARLY = 'yearly';
    const MONTHLY = 'monthly';
    const DAILY = 'daily';

    public function __construct(Order $order)
    {
        $this->model = $order;

    }

    public function getOrderChart($type){
        switch ($type){
            case self::YEARLY:
                return $this->model
                    ->select(DB::raw('CONCAT(YEAR(created_at), " year" ) AS period , COUNT(*) AS orders'))
                    ->groupBy('period')
                    ->get();
            case self::MONTHLY:
                return $this->model
                    ->select(DB::raw('CONCAT(YEAR(NOW()), "-", MONTH(created_at)) AS period, COUNT(*) AS orders'))
                    ->whereRaw('YEAR(created_at) = YEAR(NOW())')
                    ->groupBy('period')
                    ->get();
            case self::DAILY:
                return $this->model
                    ->select(DB::raw('CONCAT(YEAR(NOW()), "-", MONTH(NOW()), "-", DAY(created_at)) AS period, COUNT(*) AS orders'))
                    ->whereRaw('YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW())')
                    ->groupBy('period')
                    ->get();
        }
        return null;
    }
}
