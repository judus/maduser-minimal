<?php namespace Maduser\Minimal\Routers;

use Maduser\Minimal\Providers\Provider;
use Maduser\Minimal\Routers\Route;

class RouteProvider extends Provider
{
    public function resolve()
    {
        return new Route();
    }
}