<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Path;

class PathMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $urls = Path::all();
        foreach($urls as $url){
            if ($url->url === $request->path()) return $next($request);
        }

        $path = new Path;
        $path->url = $request->path();
        $path->save();
        return $next($request);
    }
}
