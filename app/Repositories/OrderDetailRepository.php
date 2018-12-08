<?php

namespace App\Repositories;

use App\Model\OrderDetail;
use App\Model\Taggable;

class OrderDetailRepository
{
	use BaseRepository;

	protected $model;

	public function __construct(OrderDetail $order)
	{
		$this->model = $order;

	}
}
