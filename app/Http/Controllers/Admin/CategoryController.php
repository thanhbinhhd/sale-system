<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $categories = $this->category->all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('admin.categories.create');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        $category = $this->category->getById($id);
        return view('admin.categories.edit', ['category' => $category]);
    }

    /**
     * @param CreateCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCategoryRequest $request) {
        $category = $this->category->store(array_merge($request->all(),
                [
                    'admin_id'  => Auth::guard('admin')->user()->id,
                    'image_path' => "/admin/images/avatar.jpg"
                ]));
        $avatar = $request->file('image');
        $image_path = $avatar->store('images/categories');
        $this->category->update($category->id, ['image_path' => '/storage/' . $image_path,]);

        \Session::flash('message', 'Successfully created new "'. $category->name . '"!');
        return redirect()->route('admin.category-manager.index');

    }

    /**
     * @param UpdateCategoryRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, $id) {
        $category = $this->category->getById($id);
        $this->category->update($id, $request->all());

        if ($request->hasFile('image')){
            $avatar = $request->file('image');
            $image_path = $avatar->store('images/categories');
            $this->category->update($id, ['image_path' => '/storage/' . $image_path,]);
        }

        \Session::flash('message', 'Update category "'. $category->name . '" successfully!');
        return redirect()->route('admin.category-manager.edit', ['id' => $id]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        $admin = Auth::guard('admin')->user();
        if($admin->isAdmin() or $admin->adminPermission->can_delete) {
            $status = $this->category->destroy($id);
            return response()->json(['data' => $status], self::CODE_DELETE_SUCCESS);
        }else{
            return response()->json(['message' => 'Not permission'], self::CODE_FORBIDDEN);
        }
    }
}
