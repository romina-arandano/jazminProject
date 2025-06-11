<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
        protected function redirectTo($request): ?string
        {
            if (!$request->expectsJson()) {
                // En APIs no redirigimos, solo abortamos con 401
                abort(401, 'No autorizado');
            }

            return null;
    }
}
