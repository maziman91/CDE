<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
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
        // Check if the path matches the configured paths
        if (!$this->isPathMatch($request)) {
            return $next($request);
        }

        // Handle preflight OPTIONS request
        if ($request->isMethod('OPTIONS')) {
            $response = response('', 204);
        } else {
            $response = $next($request);
        }

        // Add CORS headers
        $headers = [
            'Access-Control-Allow-Origin' => $this->getAllowedOrigins($request),
            'Access-Control-Allow-Methods' => implode(', ', config('cors.allowed_methods', [])),
            'Access-Control-Allow-Headers' => implode(', ', config('cors.allowed_headers', [])),
        ];

        if (config('cors.supports_credentials')) {
            $headers['Access-Control-Allow-Credentials'] = 'true';
        }

        $exposed = config('cors.exposed_headers', []);
        if (!empty($exposed)) {
            $headers['Access-Control-Expose-Headers'] = implode(', ', $exposed);
        }

        $maxAge = config('cors.max_age', 0);
        if ($maxAge > 0) {
            $headers['Access-Control-Max-Age'] = $maxAge;
        }

        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }

    protected function isPathMatch(Request $request)
    {
        $paths = config('cors.paths', []);
        foreach ($paths as $path) {
            if ($path !== '/') {
                $path = trim($path, '/');
            }
            if ($request->is($path)) {
                return true;
            }
        }
        return false;
    }

    protected function getAllowedOrigins(Request $request)
    {
        $allowedOrigins = config('cors.allowed_origins', []);
        $origin = $request->header('Origin');

        if (in_array('*', $allowedOrigins)) {
            return '*';
        }

        if (in_array($origin, $allowedOrigins)) {
            return $origin;
        }

        // Check patterns if needed
        $patterns = config('cors.allowed_origins_patterns', []);
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $origin)) {
                return $origin;
            }
        }

        return '';
    }
}
