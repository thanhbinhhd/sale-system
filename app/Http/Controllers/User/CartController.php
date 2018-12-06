<?php

namespace App\Http\Controllers\User;

use App\Repositories\ProductRepository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
	protected $product;

	public function __construct(ProductRepository $product)
	{
		$this->product = $product;
	}

	public function index(Request $request) {
		$userId = $this->currentUser()->id;
		if($request->ajax())
		{
			$items = [];

			\Cart::session($userId)->getContent()->each(function($item) use (&$items)
			{
				$items[] = $item;
			});

			return response(array(
				'success' => true,
				'data' => $items,
				'message' => 'cart get items success'
			),200, []);
		}
		else
		{
			return view('user.cart');
		}
	}

	public function addCart(Request $request) {

		$product_id = $request->get('product_id');
		$userId = $this->currentUser()->id;
		$quantity = $request->get('quantity');
		$product = $this->product->getById($product_id);
		$productDetail = $product->productDetail();
		$customAttributes = [
			'description' => $product->description,
			'review' => $product->review,
			'size' => isset($productDetail) ? '' : $productDetail->first()->size,
			'color' => isset($productDetail) ? '' : $productDetail->first()->color,
			'image_path' => $product->image_path,
		];

		$item = \Cart::session($userId)
			->add($product->id, $product->name, $product->price, $quantity, $customAttributes);
		return response(array(
			'success' => true,
			'data' => \Cart::session($userId)->getContent(),
			'message' => "item added."
		),201,[]);
	}

	public function details()
	{
		$userId = $this->currentUser()->id; // get this from session or wherever it came from

		return response(array(
			'success' => true,
			'data' => array(
				'total_quantity' => \Cart::session($userId)->getTotalQuantity(),
				'sub_total' => \Cart::session($userId)->getSubTotal(),
				'total' => \Cart::session($userId)->getTotal(),
			),
			'message' => "Get cart details success."
		),200,[]);
	}


}
