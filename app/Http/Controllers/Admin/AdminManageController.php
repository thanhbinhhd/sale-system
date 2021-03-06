<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\EditAdminRequest;
use App\Repositories\AdminPermissionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AdminRepository;
use App\Model\Admin;
use App\Model\AdminPermission;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
class AdminManageController extends Controller
{
    protected $admin;
    protected $admin_permission;

    public function __construct(AdminRepository $admin, AdminPermissionRepository $permission)
    {
        $this->admin = $admin;
        $this->admin_permission = $permission;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = $this->admin->all();
        return view('admin.admins.admins', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateAdminRequest $request)
    {
        $newAdmin = $request->all();
        if(!$request->input('status')) {
            $newAdmin = array_merge($request->all(), [
                'status' => 0
            ]);
        }
        $newAdmin['password'] = bcrypt($newAdmin['password']);
        $admin = $this->admin->store($newAdmin);
        if ($newAdmin['level'] != 1) { // is staff
            # code...
            $newAdminPermisson = array_merge($request->all(), [
                'admin_id' => $admin->id
            ]);
            $this->admin_permission->store($newAdminPermisson);
        }

        \Session::flash('message', 'Successfully created new "'. $admin->username . '"!');
        return redirect()->route('admin.admin-manager.index');

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

        $admin = $this->admin->getById($id);
        if ($admin->isAdmin())
            return redirect()->route('admin.admin-manager.index');
        $adminPermission = $admin->adminPermission()->first();
        if($adminPermission == null)
            $adminPermission = new AdminPermission;
        return view('admin.admins.edit', ['admin' => $admin, 'adminPermission' => $adminPermission]);
    }

    /**
     * Update the specified resource in storage.
     * @param EditAdminRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EditAdminRequest $request, $id)
    {
        $admin = $this->admin->getById($id);
        if ($admin->isAdmin())
            return redirect()->route('admin.admin-manager.index');
        $newAdmin = array_merge($request->all(), [
                'status' => $request->input('status') or Admin::BLOCKED,
        ]);
        $newAdminPermisson = array_merge($request->all(), [
                    'admin_id' => $id
                ]);
        if(!empty($request->input('password'))) {
            $newAdmin['password'] = bcrypt($request->input('password'));
        }
        $updatable = ['name', 'password', 'status', 'level'];
        $newAdmin =  array_filter(array_intersect_key($newAdmin, array_flip($updatable)));
        $admin = $this->admin->updateColumn($id, $newAdmin);
        
        if ($newAdmin['level'] != 1) { // is staff
            # code...
            $admin= $this->admin->getById($id);
            if($admin->AdminPermission != null)
                $admin->AdminPermission->delete();
            $this->admin_permission->store($newAdminPermisson);
        }

        \Session::flash('message', 'Successfully updated admin "'. $request->input('username') . '"!');
        return Redirect::to('/admin/admin-manager');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::destroy($id);
        return response()->json(['data'=> '0'], 200);
    }

    /** Update status of Admin is active or blocked
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request){
        $status = $request->get('status');
        $id=$request->get('id');
        $admin = Admin::find($id);
        $admin->status = $status;
        $admin->save();
        return response()->json(['data'=>$status], 200);
    }
}
