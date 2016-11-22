<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\Route;

class RouteProvider extends Provider
{
    public function resolve()
    {
        return new Route();
    }
}