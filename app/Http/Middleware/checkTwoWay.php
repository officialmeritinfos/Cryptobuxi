<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkTwoWay
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
        $user = Auth::user();
        if ($user->twoWay !=1){
            return $next($request);
        }elseif ($user->twoWay ==1 && $user->twowayPassed == 1){
            return $next($request);
        }else{
            $url = route('twoway', ['email' => $user->email]);
            return redirect($url)->with('error','2FA active on account and must be completed');
        }
    }
}
