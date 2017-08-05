<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Facades\IOC;
use Maduser\Minimal\Routers\Router;

/**
 * Class RouterProvider
 *
 * @package Maduser\Minimal\Providers
 */
class RouterProvider extends AbstractProvider
{
    /**
     * @return mixed
     */
    public function resolve()
    {
        return $this->singleton('Router', new Router(
            IOC::resolve('Config'),
            IOC::resolve('Request'),
            IOC::resolve('Route'),
            IOC::resolve('Response')
        ));
    }
}