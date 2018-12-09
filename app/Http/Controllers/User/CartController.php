<?php

namespace App\Http\Controllers\User;

use App\Repositories\ProductRepository;
use Cart;
use App\Repositories\SlideRepository;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
	protected $product;
	protected $slide;

	public function __construct(ProductRepository $product, SlideRepository $slide)
	{
		$this->product = $product;
		$this->slide = $slide;
	}

	public function index(Request $request) {
		$userId = $this->currentUser()->id;
		$slides = $this->slide->all();
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
			return view('user.cart', compact('slides'));
		}
	}

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
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
            'discount' =>  $product->discount(),
            'oldPrice' => $product->price,
        ];

		$item = \Cart::session($userId)
			->add($product->id, $product->name, $product->discountedPrice(), $quantity, $customAttributes);
		return response(array(
			'success' => true,
			'data' => \Cart::session($userId)->getContent(),
			'message' => "item added."
		),201,[]);
	}

	public function details(Request $request)
	{
		$userId = $this->currentUser()->id; // get this from session or wherever it came from

		return response(array(
			'success' => true,
			'data' => array(
				'total_quantity' => \Cart::session($userId)->getTotalQuantity(),
				'sub_total' => \Cart::session($userId)->getSubTotal(),
				'total' => \Cart::session($userId)->getToTal(),
			),
			'message' => "Get cart details success."
		),200,[]);
	}

	public function update(Request $request) {
		$userId = $this->currentUser()->id; // get this from session or wherever it came from
		$product_id = $request->get('product_id');
		$quantity = $request->get('quantity');
		$quantityOfProductInCart = \Cart::session($userId)->get($product_id)->quantity;
		$quantityOfProduct = $this->product->getQuantity($product_id);
		if($quantity <= 0) {
			return response(array(
				'success' => false,
				'data' => \Cart::session($userId)->getContent(),
				'message' => "Update false!"
			),200,[]);
		}
		if($quantity > $quantityOfProduct) {
			return response(array(
				'success' => false,
				'data' => \Cart::session($userId)->getContent(),
				'message' => "Cannot update quantity of this product"
			),200,[]);
		}
		$quantityUpdate = $quantity - $quantityOfProductInCart;
		\Cart::update($product_id, ['quantity' => $quantityUpdate]);
		return response(array(
			'success' => true,
			'data' => \Cart::session($userId)->getContent(),
			'message' => "Update Cart Success"
		),200,[]);
	}

	public function remove($id, Request $request) {
		$userId = $this->currentUser()->id; // get this from session or wherever it came from
		$product_id = $id;
		$cart = \Cart::session($userId)->remove($product_id);
		return response(array(
			'success' => true,
			'data' => \Cart::session($userId)->getContent(),
			'message' => "Remove Success"
		),200,[]);
	}

}
