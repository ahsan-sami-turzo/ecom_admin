<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VendorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->status == 'PENDING_INFO_ENTRY') {
            return redirect(route('vendor-information'));
        }elseif (auth()->user()->user_type == 'vendor')
            return redirect(('vendor/dashboard'));
        else{
            return $next($request);
        }
    }
}
