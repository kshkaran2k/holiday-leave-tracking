<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Model\User;
use Illuminate\Support\Facades\Auth;

class UserAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if( Auth::check() )
        {
            /** @var User $user */
            $user = Auth::user();

            // if user is not admin take him to his dashboard
            if ( $user->hasRole('admin') ) {
                return redirect(route('admin_dashboard'));
            }

            // if user is not manager take him to his dashboard
            if ( $user->hasRole('manager') ) {
                return redirect(route('manager_dashboard'));
            }

            // allow user to proceed with request
            else if ( $user->hasRole('user') ) {
                return $next($request);
            }
        }
        // return $next($request);
        abort(403);
    }
}
