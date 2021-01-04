<?php

namespace App\Http\Middleware;

use Closure;

class ForNoHealthCertificateOnly
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
        if ($request->route('applicant')->health_certificate != null) {
            return back();
        }

        return $next($request);
    }
}
