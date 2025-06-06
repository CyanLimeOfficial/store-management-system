<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckStoreExist
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Check if the user has an associated store_user record
        if (Auth::check() && Auth::user()->store_info()->count() === 0) {
            return redirect('/get-started');
        }
        return $next($request);
    }
}
