<?php namespace Maduser\Minimal\Middlewares;

use Maduser\Minimal\Loaders\IOC;
use Maduser\Minimal\Providers\Provider;

/**
 * Class MiddlewareProvider
 *
 * @package Maduser\Minimal\Middlewares
 */
class MiddlewareProvider extends Provider
{
    /**
     * @param null $params
     *
     * @return object
     */
    public function resolve($params = null)
    {
        return IOC::make(Middleware::class, $params);
    }
}