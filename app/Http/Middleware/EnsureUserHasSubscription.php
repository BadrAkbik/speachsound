<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()->subscription()->count() || $request->user()->subscription()->status === 'inactive' || $request->user()->subscription()->end_date < Carbon::now()->format('Y-m-d')) {
            return response()->json(['success' => false, 'message' => __('api.unsubscribed_message')], 402);
        }
        return $next($request);
    }
}
