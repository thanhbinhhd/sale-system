<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function createCategory(Request $request){
        $name = $request->get('name');
        $desc = $request->get('desc');
        $adminID = $request->get('adminID');
        $categoryNew = array("name"=>$name, "description"=>$desc, "admin_id"=>$adminID);
        $id = $this->category->store($categoryNew)->id;
        return response()->json(['data'=>$id], 200);
    }

    public function updateCategory(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        $desc = $request->get('desc');
        $adminID = $request->get('adminID');
        $updateArray = array("name"=>$name, "description"=>$desc, "admin_id"=>$adminID);
        $this->category->update($id, $updateArray);
        return response()->json(['data'=>$updateArray], 200);
    }

    public function deleteCategory(Request $request){
        $id = $request->get('id');
        $this->category->destroy($id);
        return response()->json(['data'=>$id], 200);
    }
}
