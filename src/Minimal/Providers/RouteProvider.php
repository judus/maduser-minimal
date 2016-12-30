<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Core\Route;

class RouteProvider extends Provider
{
    public function resolve()
    {
        return new Route();
    }
}