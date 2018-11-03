<?php

namespace App\Http\Controllers\User\Auth;

use App\Model\SocialAccount;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class OAuthController extends Controller
{
    use AuthenticatesUsers;

    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleProviderCallbackGoogle(Request $request)
    {
        $socialUser = Socialite::driver('google')->stateless()->user();

        $socialAccount = SocialAccount::where('social_id', $socialUser->getId())->first();
        if ($socialAccount) {
            if ($socialAccount->user()->where('status', User::ACTIVE)->where('deleted_at', null)->first()) {
                $socialAccount->update([
                    'access_token' => $socialUser->token,
                    'refresh_token' => $socialUser->refreshToken,
                ]);
                $user = $socialAccount->user;
            } else {
                return redirect()->back();
            }
        } else {
            $user = User::where('email', $socialUser->getEmail())->first();
            if (!$user) {
                $user = $this->createUser($socialUser);

                $user->socialAccount()->create([
                    'providers' => 'google',
                    'social_id' => $socialUser->getId(),
                    'access_token' => $socialUser->token,
                    'refresh_token' => $socialUser->refreshToken,
                ]);
            } elseif (User::where('email', $socialUser->getEmail())->where('status', User::ACTIVE)
                ->where('deleted_at', null)->first()) {
                $user->socialAccount()->create([
                    'providers' => 'google',
                    'social_id' => $socialUser->getId(),
                    'access_token' => $socialUser->token,
                    'refresh_token' => $socialUser->refreshToken,
                ]);
            } else {
                Auth::guard('user')->login($socialAccount->user, true);
                return redirect()->route('user.home');
            }
        }
        Auth::guard('user')->login($user, true);
        return redirect()->route('user.home');
    }

    public function redirectToProviderFacebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function handleProviderCallbackFacebook(Request $request)
    {
        $socialUser = Socialite::driver('facebook')->stateless()->user();

        $socialAccount = SocialAccount::where('social_id', $socialUser->getId())->first();
        if ($socialAccount) {
            if ($socialAccount->user()->where('status', User::ACTIVE)->where('deleted_at', null)->first()) {
                $socialAccount->update([
                    'access_token' => $socialUser->token,
                    'refresh_token' => $socialUser->refreshToken,
                ]);
                $user = $socialAccount->user;
            } else {
                return redirect()->back();
            }
        } else {
            $user = User::where('email', $socialUser->getEmail())->first();
            if (!$user) {
                $user = $this->createUser($socialUser);

                $user->socialAccount()->create([
                    'providers' => 'facebook',
                    'social_id' => $socialUser->getId(),
                    'access_token' => $socialUser->token,
                    'refresh_token' => $socialUser->refreshToken,
                ]);
            } elseif (User::where('email', $socialUser->getEmail())->where('status', User::ACTIVE)
                ->where('deleted_at', null)->first()) {
                $user->socialAccount()->create([
                    'providers' => 'facebook',
                    'social_id' => $socialUser->getId(),
                    'access_token' => $socialUser->token,
                    'refresh_token' => $socialUser->refreshToken,
                ]);
            } else {
                Auth::guard('user')->login($socialAccount->user, true);
                return redirect()->route('user.home');
            }
        }

        Auth::guard('user')->login($user, true);
        return redirect()->route('user.home');
    }

    public function createUser($socialUser)
    {
        return User::create([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'avatar' => $socialUser->getAvatar(),
            'password' => Hash::make(str_random(8)),
        ]);
    }
}
