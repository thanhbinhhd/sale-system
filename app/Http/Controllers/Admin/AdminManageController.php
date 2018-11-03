<?php

namespace App\Http\Controllers\Admin;

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

    public function __construct(AdminRepository $admin)
    {
        $this->admin = $admin;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = $this->admin->all();
        return view('admin.admins', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_admin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate
        $rules = array(
            'username'  => 'required|unique:admins',
            'name'      => 'required',
            'password'  => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        // process the create
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput($request->all());
        }else{
            $newAdmin = new Admin;
            $newAdmin->name = $request->input('name');
            $newAdmin->username = $request->input('username');
            $newAdmin->password = bcrypt($request->input('password'));
            $newAdmin->level = $request->input('level');
            $newAdmin->status = ($request->input('status') or 0);
            $newAdmin->save();
            if ($newAdmin->level != 1) { // is staff
                # code...
                $newAdminPermisson = new AdminPermission;
                $newAdminPermisson->admin_id = $newAdmin->id;
                $newAdminPermisson->can_delete = ($request->input('can_delete') == 1);
                $newAdminPermisson->can_add = ($request->input('can_add') == 1);
                $newAdminPermisson->can_update = ($request->input('can_update') == 1);
                $newAdminPermisson->can_read = ($request->input('can_read') == 1);
                $newAdminPermisson->can_accept_order = ($request->input('can_accept_order') == 1);
                $newAdminPermisson->can_reject_order = ($request->input('can_reject_order') == 1);
                $newAdminPermisson->can_view_order_history = ($request->input('can_view_order_history') == 1);
                $newAdminPermisson->can_view_user = ($request->input('can_view_user') == 1);
                $newAdminPermisson->can_block_user = ($request->input('can_block_user') == 1);
                $newAdminPermisson->can_change_policies = ($request->input('can_change_policies') == 1);
                $newAdminPermisson->save();
            }

            \Session::flash('message', 'Successfully created new "'. $newAdmin->username . '"!');
            return Redirect::to('/admin/AdminManager');
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
        
        $admin = Admin::find($id);
        $adminPermission = AdminPermission::where('admin_id', $id)->first();
        if($adminPermission == null)
            $adminPermission = new AdminPermission;
        return view('admin.edit_admin', ['admin' => $admin, 'adminPermission' => $adminPermission]);
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
        $newAdmin = Admin::find($id);
        $newAdminPermisson = AdminPermission::where('admin_id', $id)->first();
        if($newAdminPermisson == null)
            $newAdminPermisson = new AdminPermission;
        //Validate
        $rules = array(
            'username'  => 'required',
            'name'      => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        // process the create
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput($request->all());
        }else{
            $newAdmin->name = $request->input('name');
            if($request->input('password'))
                $newAdmin->password = bcrypt($request->input('password'));
            $newAdmin->level = $request->input('level');
            $newAdmin->status = ($request->input('status') or 0);
            $newAdmin->save();
            if ($newAdmin->level != 1) { // is staff
                # code...
                $newAdminPermisson->admin_id = $newAdmin->id;
                $newAdminPermisson->can_delete = ($request->input('can_delete') == 1);
                $newAdminPermisson->can_add = ($request->input('can_add') == 1);
                $newAdminPermisson->can_update = ($request->input('can_update') == 1);
                $newAdminPermisson->can_read = ($request->input('can_read') == 1);
                $newAdminPermisson->can_accept_order = ($request->input('can_accept_order') == 1);
                $newAdminPermisson->can_reject_order = ($request->input('can_reject_order') == 1);
                $newAdminPermisson->can_view_order_history = ($request->input('can_view_order_history') == 1);
                $newAdminPermisson->can_view_user = ($request->input('can_view_user') == 1);
                $newAdminPermisson->can_block_user = ($request->input('can_block_user') == 1);
                $newAdminPermisson->can_change_policies = ($request->input('can_change_policies') == 1);
                $newAdminPermisson->save();
            }

            \Session::flash('message', 'Successfully updated admin "'. $newAdmin->username . '"!');
            return Redirect::to('/admin/AdminManager');
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
        Admin::destroy($id);
        return response()->json(['data'=> '0'], 200);
    }

    public function updateStatus(Request $request){
        $status = $request->get('status');
        $id=$request->get('id');
        $admin = Admin::find($id);
        $admin->status = $status;
        $admin->save();
        return response()->json(['data'=>$status], 200);
    }
}
