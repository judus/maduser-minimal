<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Core\Router;

class RouterProvider extends Provider
{
    public function resolve()
    {
        return $this->singleton('Router', new Router(
            IOC::resolve('Config'),
            IOC::resolve('Request'),
            IOC::resolve('Route'),
            IOC::resolve('Response'),
            IOC::resolve('View')
        ));
    }
}