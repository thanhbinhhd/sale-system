<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Model\Category;
use App\Model\News;
use App\Model\Tag;
use App\Model\Taggable;
use App\Repositories\NewsRepository;
use App\Repositories\TaggableRepository;
use App\Repositories\TagRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller {
    protected $blog;

    public function __construct(NewsRepository $blog) {
        $this->blog = $blog;
    }

    public function index() {
        $blogs = $this->blog->all();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create() {
        return view('admin.blogs.create');
    }

    public function store(CreateBlogRequest $request) {

        $blog = $this->blog->store(array_merge($request->all(),
                [
                    'admin_id'  => Auth::guard('admin')->user()->id,
                    'status'    => $request->has('status')?1:0,
                ]));
        $avatar = $request->file('image');
        $image_path = $avatar->store('images/blogs');
        $this->blog->update($blog->id, ['thumbnail_path' => '/storage/' . $image_path,]);

        if ($request->has('tag')) {
            foreach ($request->input('tag') as $tag) {
                (new TaggableRepository(new Taggable()))->store([
                    'tag_id' => $tag,
                    'taggable_id' => $blog->id,
                    'taggable_type' => News::class
                ]);
            }
        }

        \Session::flash('message', 'Successfully created new "'. $blog->title . '"!');
        return redirect()->route('admin.blog-manager.index');

    }

    public function edit($id) {
        $blog = $this->blog->getById($id);
        return view('admin.blogs.edit', ['blog' => $blog]);
    }

    public function update(UpdateBlogRequest $request, $id) {
        $blog = $this->blog->getById($id);
        $this->blog->update($id, $request->all());

        if ($request->hasFile('image')){
            $avatar = $request->file('image');
            $image_path = $avatar->store('images/blogs');
            $this->blog->update($id, ['thumbnail_path' => '/storage/' . $image_path,]);
        }

        if ($request->has('tag')) {
            $blog->taggables()->delete();
            foreach ($request->input('tag') as $tag) {
                (new TaggableRepository(new Taggable()))->store([
                    'tag_id' => $tag,
                    'taggable_id' => $blog->id,
                    'taggable_type' => News::class
                ]);
            }
        }

        \Session::flash('message', 'Update blog "'. $blog->title . '" successfully!');
        return redirect()->route('admin.blog-manager.edit', ['id' => $id]);
    }

    public function updateStatus(Request $request) {
        $status = $request->get('status');
        $id=$request->get('id');
        $admin = Auth::guard('admin')->user();
        if($admin->isAdmin() or $admin->adminPermission->can_update) {
            $this->blog->updateStatus($status,$id);
            return response()->json(['data'=>$status], self::CODE_UPDATE_SUCCESS);
        }else{
            return response()->json(['message' => 'Not permission'], self::CODE_FORBIDDEN);
        }
    }

    public function destroy($id) {
        $admin = Auth::guard('admin')->user();
        if($admin->isAdmin() or $admin->adminPermission->can_delete) {
            $status = $this->blog->destroy($id);
            return response()->json(['data' => $status], self::CODE_DELETE_SUCCESS);
        }else{
            return response()->json(['message' => 'Not permission'], self::CODE_FORBIDDEN);
        }
    }
}
