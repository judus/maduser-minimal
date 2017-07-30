<?php namespace Maduser\Minimal\Routers;

use Maduser\Minimal\Providers\Provider;


class RouteProvider extends Provider
{
    public function resolve()
    {
        return new Route();
    }
}