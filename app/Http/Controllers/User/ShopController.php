<?php

namespace App\Http\Controllers\User;

use App\Model\Category;
use App\Model\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TraitUseAdaptation\Alias;

class ShopController extends Controller
{
    //

    protected $category;
    protected $product;
    const CATEGORY_PAGINATION = 10;
    const ALL = 'All';
    public function __construct(CategoryRepository $category, ProductRepository $product)
    {
        $this->category = $category;
        $this->product = $product;
    }

    /** show shop view with category is specified
     * @param $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($category){
        // When category is All
        if ($category == self::ALL){
            return view('user.shop', ['products' => $this->product->page(self::CATEGORY_PAGINATION), 'categoryName' => $category]);
        }

        //Find category model by name
        $categoryModel = $this->category->getByName($category);
        //When category found
        if ($categoryModel != null){
            $products = $categoryModel->products()->paginate(self::CATEGORY_PAGINATION);
            return view('user.shop', ['products' => $products, 'categoryName' => $category]);
        }
        //When category not found
        return view('user.shop', ['products' => null,'categoryName' => $category]);

    }

    /** filter for shop view
     * @param $category
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filte($category, Request $request){
        if($category == self::ALL)
            $products = DB::table('products');
        else{
            $categoryModel = $this->category->getByName($category);
            if ($categoryModel == null) {
                //When category not found
                return view('user.shop', ['products' => null, 'categoryName' => $category]);
            }
            else {
                $products = $categoryModel->products();
            }
        }

        $products = $this->product->filte($products, $request)->paginate(self::CATEGORY_PAGINATION);
        return view('user.shop', ['products' => $products, 'categoryName' => $category]);
    }
}
