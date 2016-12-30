<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Core\IOC;
use Maduser\Minimal\Core\Router;

class RouterProvider extends Provider
{
    public function resolve()
    {
        return $this->singleton('Router', new Router(
            IOC::resolve('Config'),
            IOC::resolve('Request'),
            IOC::resolve('Route'),
            IOC::resolve('Response'),
            IOC::resolve('CollectionFactory')
        ));
    }
}