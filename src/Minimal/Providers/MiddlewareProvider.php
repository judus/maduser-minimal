<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Core\IOC;
use Maduser\Minimal\Core\Middleware;


class MiddlewareProvider extends Provider
{
    public function resolve($params = null)
    {
        return IOC::make(Middleware::class, $params);
    }
}