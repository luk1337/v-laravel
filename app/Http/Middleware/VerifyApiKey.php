<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (is_null($request->api_key)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing API key.',
            ], 401);
        }

        $user = User::where('api_key', $request->api_key)->first();

        if (is_null($user)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API key.',
            ], 401);
        }

        return $next($request);
    }
}
