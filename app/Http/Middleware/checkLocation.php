<?php

namespace App\Http\Middleware;

use App\Custom\Regular;
use Closure;
use Illuminate\Http\Request;

class checkLocation
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
        $ip= $request->ip();
        //check if the link has a country
        if ($request->has('country')) {
            return $next($request);
        }else{
            //check the user's location
            $ipDetector = new Regular();
            $agents = $ipDetector->getUserCountry($ip);
            if ($agents->ok()) {
                $locations = $agents->json();
                $country=$locations['country_code2'];
                $urlTo = $request->fullUrlWithQuery(['country' => $country]);
                return redirect($urlTo);
            }
            return $next($request);
        }
    }
}
