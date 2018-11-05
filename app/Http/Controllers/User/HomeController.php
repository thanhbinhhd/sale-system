<?php

namespace App\Http\Controllers\User;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SlideRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $user;
    protected $tag;
    protected $slide;
    protected $category;
    protected $product;


    public function __construct(UserRepository $user, TagRepository $tag, SlideRepository $slide,
                                CategoryRepository $category, ProductRepository $product)
    {
        $this->user = $user;
        $this->category = $category;
        $this->tag = $tag;
        $this->slide = $slide;
        $this->product = $product;
    }

    public function index(){
        $slides = $this->slide->all();
        $categories = $this->category->all();
        $tags = $this->tag->all();
        $cheaps = $this->product->getWithCondition("price","DESC");
        $views = $this->product->getWithCondition('number_viewed',"ASC");
        $products = $this->product->getNew();
        return view('user.home',compact('slides','tags', 'categories', 'cheaps', 'products', 'views'));
    }
}
