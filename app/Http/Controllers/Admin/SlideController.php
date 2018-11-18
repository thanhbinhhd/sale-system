<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SlideRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSlideRequest;
use App\Http\Requests\UpdateSlideRequest;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    protected $slide;

    public function __construct(SlideRepository $slide){
        $this->slide = $slide;
    }

    public function index(){
        $slides = $this->slide->all();
        return view('admin.slides', compact('slides'));
    }

    public function createSlide(CreateSlideRequest $request){
        $title = $request->get('title');
        $link = $request->get('link');
        $status = 1;
        $slideNew = array("title"=>$title, "link"=>$link, "status"=>$status);
        $id = $this->slide->store($slideNew)->id;
        return response()->json(['data'=>$id], self::CODE_CREATE_SUCCESS);
    }

    public function updateSlide(UpdateSlideRequest $request){
        $id = $request->get('id');
        $title = $request->get('title');
        $link = $request->get('link');
        $updateArray = array("title"=>$title, "link"=>$link);
        $this->slide->update($id, $updateArray);
        return response()->json(['data'=>$updateArray], self::CODE_UPDATE_SUCCESS);
    }
    
    public function deleteSlide(Request $request){
        $id = $request->get('id');
        $this->slide->destroy($id);
        return response()->json(['data'=>$id], self::CODE_DELETE_SUCCESS);
    }

    public function updateSlideStatus(Request $request){
        $status = $request->get('status');
        $id = $request->get('id');
        $statusArray = array("status"=>$status);
        $this->slide->update($id, $statusArray);
        return response()->json(['data'=>$statusArray], self::CODE_UPDATE_SUCCESS);
    }

    public function uploadImage(Request $request){
        $avatar = $request->file('file');
        $name = $request->get('name');
        $image_path = $avatar->storeAs(
            'images/slides', $name.'.png'
        );
        return response()->json(['data'=>$name], self::CODE_UPDATE_SUCCESS);
    }

    public function changeImageName(Request $request){
        $oldName = $request->get('oldName');
        $newName = $request->get('newName');
        if($oldName != $newName){
            Storage::move('images/slides/'.$oldName.'.png', 'images/slides/'.$newName.'.png');
        }
        return response()->json(['data'=>$oldName], self::CODE_UPDATE_SUCCESS);
        
    }

}
