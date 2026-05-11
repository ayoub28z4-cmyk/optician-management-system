<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class JournalRequetes
{
    public function handle(Request $request, Closure $next): Response
    {
        Log::channel('single')->info('stock.requete', [
            'user'   => $request->user()?->id,
            'method' => $request->method(),
            'url'    => $request->url(),
            'ip'     => $request->ip(),
        ]);

        return $next($request);
    }
}
