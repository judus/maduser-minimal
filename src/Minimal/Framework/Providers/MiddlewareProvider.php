<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Framework\Facades\IOC;
use Maduser\Minimal\Middlewares\Middleware;

/**
 * Class MiddlewareProvider
 *
 * @package Maduser\Minimal\Middlewares
 */
class MiddlewareProvider extends AbstractProvider
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