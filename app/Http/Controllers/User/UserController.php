<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\ChangePasswordRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function changePass(ChangePasswordRequest $request){
        $currentPass = $request->get('old_password');
        $newPass=$request->get('new_password');
        $user = $this->user->currentUser();
        if(Hash::check($currentPass, $user->password)){
            $this->user->updateColumn($this->user->currentUser()->id, ['password' => bcrypt($newPass)]);
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

    public function uploadAvatar(Request $request) {
		try {
			$this->validate($request, ['avatar' => ['required', 'image']]);
			$filename = time() . str_random(16) . '.png';

			$image = $request->file('avatar')->getRealPath();
			$folder = config('sales.avatar_folder');
			Storage::put($folder . '/' . $filename,file_get_contents($image));
			$imageAddress = $folder . '/' . $filename;

			// delete the old avatar
			if (isset($this->user->currentUser()->avatar)) {
				Storage::delete($folder . str_after($this->user->currentUser()->avatar, $folder));
			}
			$this->user->updateColumn($this->user->currentUser()->id, ['avatar' => $imageAddress,]);
			return response()->json(['image_address' => Storage::url($imageAddress)], 200);
		} catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], self::CODE_NOT_IMPLEMENTED);
		}
    }
}
