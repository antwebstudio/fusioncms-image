<?php

namespace Addons\Image\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ImageManipulatorParams
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $watermarkName = 'default')
    {
        $request->merge([
            'w' => $request->w,
            'h' => $request->h,
            'fit' => $request->fit,
        ]);
        return $next($request);
    }
}
