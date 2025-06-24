<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;

class TrustProxies
{
    /**
     * Either '*' to trust all proxies (Cloudflare),
     * or list of IPs if you're more strict.
     */
    protected $proxies = '*';

    /**
     * Headers to use for detecting proxy forwarding.
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}