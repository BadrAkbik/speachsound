<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Interfaces\MustVerifyMobile;
use App\Traits\ApiResponse;

class EnsureMobileIsVerifiedMiddleware
{
    use ApiResponse;
    public function handle(Request $request, Closure $next, $redirectToRoute = null)
    {
        if (
            !$request->user() ||
            ($request->user() instanceof MustVerifyMobile &&
                !$request->user()->hasVerifiedMobile())
        ) {
            return $this->throw(__('auth.Your mobile number is not verified.'), 409);
        }

        return $next($request);
    }
}
