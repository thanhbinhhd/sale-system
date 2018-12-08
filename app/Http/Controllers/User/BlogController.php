<?php

namespace App\Http\Controllers\User;

use App\Repositories\CategoryRepository;
use App\Repositories\NewsRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    protected $user;
    protected $tag;
    protected $category;
    protected $product;
    protected $blog;


    public function __construct(UserRepository $user, TagRepository $tag,
                                CategoryRepository $category, ProductRepository $product, NewsRepository $blog)
    {
        $this->user = $user;
        $this->category = $category;
        $this->tag = $tag;
        $this->product = $product;
        $this->blog = $blog;

    }

    public function index(){
        $user = $this->user->currentUser();
        $categories = $this->category->getNew();
        $tags = $this->tag->all();
        $products = $this->product->getNew();
        $blogs = $this->blog->all();
        return view('user.blog',compact('user','tags', 'categories', 'products', 'blogs'));
    }

    public function details($blogSlug){

        //Find blog model by slug
        $blog = $this->blog->getBySlug($blogSlug);

        $user = $this->user->currentUser();
        $categories = $this->category->getNew();
        $tags = $this->tag->all();
        $products = $this->product->getNew();
        return view('user.blog-details',compact('user','tags', 'categories', 'products', 'blog'));

  }
}
