<?php

namespace App\Http\Controllers\User;

use App\Repositories\CategoryRepository;
use App\Repositories\NewsRepository;
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
    protected $blog;


    public function __construct(UserRepository $user, TagRepository $tag, SlideRepository $slide,
                                CategoryRepository $category, ProductRepository $product, NewsRepository $blog)
    {
        $this->user = $user;
        $this->category = $category;
        $this->tag = $tag;
        $this->slide = $slide;
        $this->product = $product;
        $this->blog = $blog;

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $user = $this->user->currentUser();
        $slides = $this->slide->all();
        $categories = $this->category->all();
        $tags = $this->tag->all();
        $cheaps = $this->product->getWithCondition("price","DESC");
        $views = $this->product->getWithCondition('number_viewed',"ASC");
        $products = $this->product->getNew();
        $blogs = $this->blog->getNew();
        return view('user.home',compact('user','slides','tags', 'categories', 'cheaps', 'products', 'views','blogs'));
    }
}
