<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localize
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $language = auth()->user()->language;
        } else {
            $language = $request->headers->get('X-Language');

            if (! in_array($language, config('app.accepted_languages'))) {
                $language = config('app.locale');
            }
        }

        app()->setLocale($language);
        $request->headers->set('Content-Language', $language);

        return $next($request);
    }
}
