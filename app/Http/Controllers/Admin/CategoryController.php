<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function index(){
        $categories = $this->category->all();
        return view('admin.categories', compact('categories'));
    }

    public function createCategory(CreateCategoryRequest $request){
        $name = $request->get('name');
        $desc = $request->get('desc');
        $imagePath = $request->get('imagePath');
        $adminID = $request->get('adminID');
        $categoryNew = array("name"=>$name, "description"=>$desc, "admin_id"=>$adminID, "image_path"=>$imagePath);
        $id = $this->category->store($categoryNew)->id;
        return response()->json(['data'=>$id], self::CODE_CREATE_SUCCESS);
    }

    public function updateCategory(UpdateCategoryRequest $request){
        $id = $request->get('id');
        $name = $request->get('name');
        $desc = $request->get('desc');
        $imagePath = $request->get('imagePath');
        $adminID = $request->get('adminID');
        $updateArray = array("name"=>$name, "description"=>$desc, "admin_id"=>$adminID, "image_path"=>$imagePath);
        $this->category->update($id, $updateArray);
        return response()->json(['data'=>$updateArray], self::CODE_UPDATE_SUCCESS);
    }

    public function deleteCategory(Request $request){
        $id = $request->get('id');
        $this->category->destroy($id);
        return response()->json(['data'=>$id], self::CODE_DELETE_SUCCESS);
    }
}
