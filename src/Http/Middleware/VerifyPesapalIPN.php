<?php

namespace CollinsLagat\LaravelPesapal\Http\Middleware;

use Closure;

class VerifyPesapalIPN
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     *
     */
    public function handle($request, Closure $next)
    {
        if ($request->host() !== 'pesapal.com') {
            return response()->json([
                'status' => 500,
                'message' => 'Invalid request',
            ]);
        }
        return $next($request);
    }
}
