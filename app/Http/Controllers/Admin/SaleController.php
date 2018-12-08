<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateSaleRequest;
use App\Model\ProductSale;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductSaleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    protected $sale;
    protected $category;
    public function __construct(ProductSaleRepository $sale, CategoryRepository $category)
    {
        $this->sale = $sale;
        $this->category = $category;
    }


    public function index(){
        return view('admin.sale.index', ['sales' => $this->sale->all()]);
    }

    public function create(){
        return view('admin.sale.create', ['categories' => $this->category->all()]);
    }

    public function store(CreateSaleRequest $request){
        foreach ($request->get('product_id') as $product_id){
            (new ProductSaleRepository(new ProductSale()))->store(array_merge($request->all(),
                            ['product_id' => $product_id,
                                'admin_id' => Auth::guard('admin')->user()->id]));
        }
        \Session::flash('message', 'Successfully created new sale-off!');
        return redirect()->route('admin.sale-manager.index');
    }

    public function show(){
            // Do not delete this function, maybe raise bug, because it is resource controller
    }

    public function listProducts(Request $request){
        return response()->json(
            ['data' => $this->category->getById($request->get('id'))->products],
            self::CODE_GET_SUCCESS);
    }
}
