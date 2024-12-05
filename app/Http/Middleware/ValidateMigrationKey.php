<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateMigrationKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $accessKey = config('app.migration_key');
        $providedKey = $request->get('key');

        if ($accessKey !== $providedKey) {
            return response()->json(['error' => true, 'message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
