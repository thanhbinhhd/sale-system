<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Model\Category;
use App\Model\Product;
use App\Model\Image;
use App\Model\Tag;
use App\Model\Taggable;
use App\Repositories\ImageRepository;
use App\Repositories\ProductDetailRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TaggableRepository;
use App\Repositories\TagRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    protected $product;
    protected $image;
    protected $detail;
    public function __construct(ProductRepository $product, ImageRepository $image, ProductDetailRepository $detail)
    {
        $this->product = $product;
        $this->image = $image;
        $this->detail = $detail;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * @param CreateProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateProductRequest $request)
    {

        $product = $this->product->store(array_merge($request->all(),
                [
                    'admin_id'  => Auth::guard('admin')->user()->id,
                    'status'    => $request->has('status')?1:0,
                ]));
        $avatar = $request->file('image');
        $image_path = $avatar->store('images/'. $product->category->name);
        $this->product->update($product->id, ['image_path' => '/storage/' . $image_path,]);

        $productDetail = $this->detail->store(array_merge($request->all(),
                [
                    'product_id' => $product->id,
                ]));

        if ($request->has('tag')) {
            foreach ($request->input('tag') as $tag) {
                (new TaggableRepository(new Taggable()))->store([
                    'tag_id' => $tag,
                    'taggable_id' => $product->id,
                    'taggable_type' => Product::class
                ]);
            }
        }

        if($request->hasFile('images')) {
            $files = $request->file('images');
            // duyệt từng ảnh và thực hiện lưu
            foreach ($files as $photo) {
                $filename = $photo->store('images/' . $product->category->name);
                (new ImageRepository(new Image()))->store([ // store many file
                    'image_url' => '/storage/' . $filename,
                    'imageable_id' => $product->id,
                    'imageable_type' => Product::class,
                ]);
            }
        }
        \Session::flash('message', 'Successfully created new "'. $product->name . '"!');
        return redirect()->route('admin.product-manager.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->product->getById($id);
        return view('admin.products.edit', ['product' => $product]);
    }

    /**
     * @param UpdateProductRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->product->getById($id);
        $this->product->update($id, $request->all());

        if ($request->hasFile('image')){
            $avatar = $request->file('image');
            $image_path = $avatar->store('images/'. $product->category->name);
            $this->product->update($id, ['image_path' => '/storage/' . $image_path,]);
        }

        if($product->productDetail == null){
            $this->detail->store(array_merge($request->all(),
                [
                    'product_id' => $product->id,
                ]));
        }else {
            $this->detail->update($product->productDetail->id, array_merge($request->all(),
                [
                    'product_id' => $product->id,
                ]));
        }
        if ($request->has('tag')) {
            $product->taggables()->delete();
            foreach ($request->input('tag') as $tag) {
                (new TaggableRepository(new Taggable()))->store([
                    'tag_id' => $tag,
                    'taggable_id' => $product->id,
                    'taggable_type' => Product::class
                ]);
            }
        }

        Image::destroy($request->input('todel'));

        if($request->hasFile('images')) {
            $files = $request->file('images');
            // duyệt từng ảnh và thực hiện lưu
            foreach ($files as $photo) {
                $filename = $photo->store('images/' . $product->category->name);
                (new ImageRepository(new Image()))->store([ // store many file
                    'image_url' => '/storage/' . $filename,
                    'imageable_id' => $product->id,
                    'imageable_type' => Product::class,
                ]);
            }
        }
        \Session::flash('message', 'Update product "'. $product->name . '" successfully!');
        return redirect()->route('admin.product-manager.edit', ['id' => $id]);
    }

    /**
     * Update product status
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request){
        $status = $request->get('status');
        $id=$request->get('id');
        $admin = Auth::guard('admin')->user();
        if($admin->isAdmin() or $admin->adminPermission->can_update) {
            $this->product->updateStatus($status,$id);
            return response()->json(['data'=>$status], self::CODE_UPDATE_SUCCESS);
        }else{
            return response()->json(['message' => 'Not permission'], self::CODE_FORBIDDEN);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Auth::guard('admin')->user();
        if($admin->isAdmin() or $admin->adminPermission->can_delete) {
            $status = $this->product->destroy($id);
            return response()->json(['data' => $status], self::CODE_DELETE_SUCCESS);
        }else{
            return response()->json(['message' => 'Not permission'], self::CODE_FORBIDDEN);
        }
    }
}
