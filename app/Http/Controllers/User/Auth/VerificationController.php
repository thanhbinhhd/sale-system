<?php
namespace App\Http\Controllers\User\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be resent if the user did not receive the original email message.
    |
    */
    use VerifiesEmails;
    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function show(Request $request)
    {
        return Auth::guard('user')->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('user.auth.verify');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        if ($request->route('id') == Auth::guard('user')->user()->getKey() &&
            Auth::guard('user')->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect($this->redirectPath())->with('verified', true);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if (Auth::guard('user')->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        Auth::guard('user')->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }

    public function __construct()
    {
        $this->middleware('user');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}