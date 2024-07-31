<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait IpChecks
{
    /**
     * Crude way to pull out external IP
     */
    private function getIP(Request $request): string
    {
        if (env('APP_ENV') === 'production') {
            $ip = $request->ip(); // Can't pull external IP adress in localhost
        } else {
            $ip = trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com"));
        }

        return $ip;
    }
}
