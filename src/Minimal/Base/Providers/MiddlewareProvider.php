<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Core\Middleware;


class MiddlewareProvider extends Provider
{
    public function resolve($params = null)
    {
        return IOC::make(Middleware::class, $params);
    }
}