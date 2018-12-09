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

    const BLOG_PAGINATION = 8;


    public function __construct(UserRepository $user, TagRepository $tag,
                                CategoryRepository $category, ProductRepository $product, NewsRepository $blog)
    {
        $this->user = $user;
        $this->category = $category;
        $this->tag = $tag;
        $this->product = $product;
        $this->blog = $blog;

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $user = $this->user->currentUser();
        $categories = $this->category->getNew();
        $tags = $this->tag->all();
        $products = $this->product->getNew();
        $blogs = $this->blog->page(self::BLOG_PAGINATION);
        return view('user.blog',compact('user','tags', 'categories', 'products', 'blogs'));
    }

    /**
     * @param $blogSlug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($blogSlug){
        $blog = $this->blog->getBySlug($blogSlug);
        if(!$blog){
            return redirect()->route('user.blog');
        }

        $user = $this->user->currentUser();
        $categories = $this->category->getNew();
        $tags = $this->tag->all();
        $products = $this->product->getNew();
        return view('user.blog-details',compact('user','tags', 'categories', 'products', 'blog'));

    }

    public function searchWithCategory($category){
        $user = $this->user->currentUser();
        $categories = $this->category->getNew();
        $tags = $this->tag->all();
        $products = $this->product->getNew();

        $categoryModel = $this->category->getByName($category);
        if ($categoryModel != null){
            $blogs = $categoryModel->news()->paginate(self::BLOG_PAGINATION);
            return view('user.blog',compact('user','tags', 'categories', 'products', 'blogs'));
        }else {
            $blogs = [];
            return view('user.blog',compact('user','tags', 'categories', 'products', 'blogs'));
        }
        
    }

    // public function searchWithTag($tag){
    //     $user = $this->user->currentUser();
    //     $categories = $this->category->getNew();
    //     $tags = $this->tag->all();
    //     $products = $this->product->getNew();

    //     $tagModel = $this->tag->getByName($tag);
    //     if ($tagModel != null){
    //         $blogs = $tagModel->news()->paginate(self::BLOG_PAGINATION);
    //         return view('user.blog',compact('user','tags', 'categories', 'products', 'blogs'));
    //     }else {
    //         $blogs = [];
    //         return view('user.blog',compact('user','tags', 'categories', 'products', 'blogs'));
    //     }
        
    // }
}
