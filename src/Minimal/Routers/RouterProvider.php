<?php namespace Maduser\Minimal\Routers;

use Maduser\Minimal\Loaders\IOC;
use Maduser\Minimal\Providers\Provider;

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