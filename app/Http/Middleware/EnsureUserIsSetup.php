<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsSetup
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->setup == 0 || Auth::user()->setup == 4)  && ! $request->is('setup*') && ! $request->is('setup') && ! $request->is('setup/*') && ! $request->is('submit_setup')) {
            if ($request->ajax()) {
                $view = view('auth.setup')->renderSections();
                return response()->json([
                    'success' => true,
                    'content' => $view['content'] ?? '',
                    'script' => $view['custom'] ?? '',
                ]);
            }

            return redirect('/setup');
        }

        return $next($request);
    }
}