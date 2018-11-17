<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateProductRequest;
use App\Model\Category;
use App\Model\Product;
use App\Model\Image;
use App\Model\Tag;
use App\Repositories\ImageRepository;
use App\Repositories\ProductDetailRepository;
use App\Repositories\ProductRepository;
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
        // kiểm tra có files sẽ xử lý
        if($request->hasFile('image')) {
            $allowedfileExtension=['jpg','png', 'jpeg'];
            $files = array($request->file('image'));
            if($request->hasFile('images'))
                $files = array_merge($request->file('images'), $files);
            // flag xem có thực hiện lưu DB không. Mặc định là có
            $exe_flg = true;
            // kiểm tra tất cả các files xem có đuôi mở rộng đúng không
            foreach($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);

                if(!$check) {
                    // nếu có file nào không đúng đuôi mở rộng thì đổi flag thành false
                    $exe_flg = false;
                    break;
                }
            }
            // nếu không có file nào vi phạm validate thì tiến hành lưu DB
            if($exe_flg) {
                // lưu product
                $product = $this->product->store(array_merge($request->all(),
                        [
                            'admin_id' => Auth::guard('admin')->user()->id,
                        ]));
                $productDetail = $this->detail->store(array_merge($request->all(),
                        [
                            'product_id' => $product->id,
                        ]));
                if ($request->has('tag')) {
                    foreach ($request->input('tag') as $tag) {
                        (new TagRepository(new Tag()))->store([
                            'name' => $tag,
                            'description' => '',
                            'tagable_id' => $product->id,
                            'tagable_type' => Product::class
                        ]);
                    }
                }
                // duyệt từng ảnh và thực hiện lưu
                foreach ($files as $photo) {
                    $filename = $photo->store('images/'. $product->category->name);
                    (new ImageRepository(new Image()))->store([ // store many file
                        'image_url' => $filename,
                        'imageable_id' => $product->id,
                        'imageable_type' => Product::class,
                    ]);
                }
                \Session::flash('message', 'Successfully created new "'. $product->name . '"!');
                return redirect()->route('admin.product-manager.index');
            } else {
                return back()->withErrors('Failed to upload. Only accept jpg, png, jpeg photos.');
            }
        }

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        if($admin->level == 1 or $admin->adminPermission->can_update) {
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
        if($admin->level == 1 or $admin->adminPermission->can_delete) {
            $status = $this->product->destroy($id);
            return response()->json(['data' => $status], self::CODE_DELETE_SUCCESS);
        }else{
            return response()->json(['message' => 'Not permission'], self::CODE_FORBIDDEN);
        }
    }
}
