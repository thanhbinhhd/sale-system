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
        $user = Auth::guard('user')->user();
        return view("user.profile",compact('user'));
    }

    public function changepass(Request $request){
        $currentpass = $request->get('currentpass');
        $newpass=$request->get('newpass');
        $user = Auth::guard('user')->user();
        if(Hash::check($currentpass, $user->password)){
            $user->password = bcrypt($newpass);
            $user->save();
            return response()->json(['data'=>"success"]);
        }
        else{
            return response()->json(['data'=>"invalidPass"]);
        }
    }
}
