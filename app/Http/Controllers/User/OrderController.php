<?php

namespace App\Http\Controllers\User;

use App\Events\AddOrder;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Repositories\OrderDetailRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\EventDispatcher\Event;


class OrderController extends Controller
{
	protected $product;
	protected $order;
	protected $orderDetail;
	public function __construct(ProductRepository $product, OrderRepository $order, OrderDetailRepository $orderDetail)
	{
		$this->product = $product;
		$this->order = $order;
		$this->orderDetail = $orderDetail;
	}

	public function addOrder(Request $request) {
		try{
			$currentUserId = $this->currentUser()->id;
			$note = $request->get('note');
			$address = $request->get('address');
			$phone_number = $request->get('phoneNumber');
			\Cart::session($currentUserId);
			$order = array_merge([], [
				'user_id' => $currentUserId,
				'quantity' => \Cart::session($currentUserId)->getTotalQuantity(),
				'sub_total' => \Cart::session($currentUserId)->getSubTotal(),
				'total' => \Cart::session($currentUserId)->getTotal(),
				'note'  => $note,
				'address'  => $address,
				'phone_number'  => $phone_number,
			]);
			$newOrder = $this->order->store($order);
			$carts = \Cart::session($currentUserId)->getContent();
			foreach (($carts) as $cart) {
				(new OrderDetailRepository(new OrderDetail()))->store([
					'product_id' => $cart->id,
					'quantity' => $cart->quantity,
					'order_id' => $newOrder->id,
					'total_price' => $cart->price,
				]);
			}
			\Cart::session($currentUserId)->clear();
			$orderDetail = $newOrder->detail()->get();
			event(new AddOrder($this->currentUser(), $newOrder, $orderDetail));
			return response()->json([
				'success' => true,
				'data' => $newOrder,
			], 200);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => $e->getMessage()
			], 200);
		}

	}


	//
}
