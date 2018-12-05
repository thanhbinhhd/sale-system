<?php

namespace App\Http\Controllers\User;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function profile(){
        $user = $this->user->currentUser();
        return view("user.profile",compact('user'));
    }

    public function changepass(Request $request){
        $currentpass = $request->get('currentpass');
        $newpass=$request->get('newpass');
        $user = $this->user->currentUser();
        if(Hash::check($currentpass, $user->password)){
            $user->password = bcrypt($newpass);
            $this->user->updatePass($user);
            return response()->json(['data'=>"success"]);
        }
        else{
            return response()->json(['data'=>"invalidPass"]);
        }
    }

    public function changeProfile(Request $request){
        $user = $this->user->currentUser();
        $user->name = $request->get('name');
        $user->phone_number = $request->get('phone');
        $user->address = $request->get('address');
        $user->description = $request->get('description');
        $this->user->updateProfile($user);
        return response()->json(['data'=>$user]);
    }
}
