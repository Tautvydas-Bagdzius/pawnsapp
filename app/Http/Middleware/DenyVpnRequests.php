<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class DenyVpnRequests
{
    const BLOCKED_IPS_PREFIX = 'ips_blocked';
    const ALLOWED_IPS_PREFIX = 'ips_allowed';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $this->getIP($request);

        if (!is_null(Cache::get(self::ALLOWED_IPS_PREFIX . '.' . $ip))) {
            return $next($request);
        }

        if (!is_null(Cache::get(self::BLOCKED_IPS_PREFIX . '.' . $ip))) {
            return $this->errorResponse();
        }

        $response = Http::get(env('PROXYCHECK_URL') . $ip . '?vpn=1&asn=1');
        $jsonRes = $response->json();

        if (
            $jsonRes['status'] !== 'error' &&
            $jsonRes[$ip]['proxy'] !== 'no'
        ) {
            Cache::put(self::BLOCKED_IPS_PREFIX . '.' . $ip, $ip, 3600);

            return $this->errorResponse();
        }

        Cache::put(self::ALLOWED_IPS_PREFIX . '.' . $ip, $ip, 3600);

        return $next($request);
    }

    /**
     * Crude way to pull out external IP
     */
    private function getIP($request): string
    {
        if (env('APP_ENV') === 'production') {
            $ip = $request->ip(); // Can't pull external IP adress in localhost
        } else {
            $ip = trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com"));
        }

        return $ip;
    }

    private function errorResponse(): JsonResponse
    {
        return response()->json('Proxy/VPN use is disallowed', 403);
    }
}
