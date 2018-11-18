<?php

namespace App\Http\Controllers\User;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    //

    public function show($category){
        $categoryModel = Category::where('name', $category)->first();
        if ($categoryModel == null)
            $categoryModel = Category::all()->first;
        $products = $categoryModel->products()->paginate(3);;
        return view('user.shop', compact('products'));

    }
}
