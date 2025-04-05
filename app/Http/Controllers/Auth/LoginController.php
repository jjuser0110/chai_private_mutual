<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\User;
use Socialite;
use Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function username()
    {
        return 'username';
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->is_active != 1) {
            Auth::logout();
            return redirect()->route('login')->withError('Your account has been locked. Please contact your Boss!');
        }else{
            $user->update(['last_login'=>Carbon::now()]);
            
            // $token = Str::random(60);
            $user->login_logs()->create([
                'user_id' => $user->id,
                'browser_detail' => $request->server('HTTP_USER_AGENT'),
                'ip_address' => $request->ip(),
                'token' => $request->session()->getId(),
                'firebase_token' => ""
            ]);

            return redirect()->route('index');
        }
    }
}
