<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckSession
{
    public function handle($request, Closure $next)
    {
        $firsttimeLogin = false;
        if(!isset(Auth::user()->last_log)){
            $firsttimeLogin = true;
        }
        if(!$firsttimeLogin){
            if (Auth::check() && Auth::user()->last_log->token !== $request->session()->getId()) {
                Auth::logout();
                return redirect('/login')->withError('You have been logged out due to a new session.');
            }
        }

        return $next($request);
    }
}
