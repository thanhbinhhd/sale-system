<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SlideRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSlideRequest;
use App\Http\Requests\UpdateSlideRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SlideController extends Controller
{
    protected $slide;

    public function __construct(SlideRepository $slide){
        $this->slide = $slide;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $slides = $this->slide->all();
        return view('admin.slides.index', compact('slides'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('admin.slides.create');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        $slide = $this->slide->getById($id);
        return view('admin.slides.edit', ['slide' => $slide]);
    }

    /**
     * @param CreateSlideRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateSlideRequest $request) {

        $slide = $this->slide->store(array_merge($request->all(),
                [
                    'status'    => $request->has('status')?1:0,
                ]));
        $avatar = $request->file('image');
        $image_path = $avatar->store('images/slides');
        $this->slide->update($slide->id, ['link' => '/storage/' . $image_path,]);

        \Session::flash('message', 'Successfully created new "'. $slide->title . '"!');
        return redirect()->route('admin.slide-manager.index');

    }

    /**
     * @param UpdateSlideRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSlideRequest $request, $id) {
        $slide = $this->slide->getById($id);
        $this->slide->update($id, $request->all());

        if ($request->hasFile('image')){
            $avatar = $request->file('image');
            $image_path = $avatar->store('images/slides');
            $this->slide->update($id, ['link' => '/storage/' . $image_path,]);
        }

        \Session::flash('message', 'Update slide "'. $slide->title . '" successfully!');
        return redirect()->route('admin.slide-manager.edit', ['id' => $id]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request) {
        $status = $request->get('status');
        $id=$request->get('id');
        $admin = Auth::guard('admin')->user();
        if($admin->isAdmin() or $admin->adminPermission->can_update) {
            $this->slide->updateStatus($status,$id);
            return response()->json(['data'=>$status], self::CODE_UPDATE_SUCCESS);
        }else{
            return response()->json(['message' => 'Not permission'], self::CODE_FORBIDDEN);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        $admin = Auth::guard('admin')->user();
        if($admin->isAdmin() or $admin->adminPermission->can_delete) {
            $status = $this->slide->destroy($id);
            return response()->json(['data' => $status], self::CODE_DELETE_SUCCESS);
        }else{
            return response()->json(['message' => 'Not permission'], self::CODE_FORBIDDEN);
        }
    }

}
