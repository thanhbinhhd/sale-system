<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use stdClass; // need to create new empty object;

class DashBoardController extends Controller
{
    protected $user;
    protected $product;
    protected $category;
    protected $order;
    public function __construct(UserRepository $user, ProductRepository $product, CategoryRepository $category, OrderRepository $order)
    {
        $this->user = $user;
        $this->product = $product;
        $this->category = $category;
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = new stdClass();;
        $count->user = $this->user->getNumber();
        $count->product = $this->product->getNumber();
        $count->category = $this->category->getNumber();
        $count->order = $this->order->getNumber();
        return view('admin.dashboard', ['count' => $count]);
    }

    public function getChart(Request $request){
        $type = $request->get('type');
        $data = $this->order->getOrderChart($type);
        return response()->json(['data' => $data], self::CODE_GET_SUCCESS);
    }

}
