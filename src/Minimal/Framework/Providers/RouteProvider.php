<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Routers\Route;

/**
 * Class RouteProvider
 *
 * @package Maduser\Minimal\Providers
 */
class RouteProvider extends AbstractProvider
{
    /**
     * @return Route
     */
    public function resolve()
    {
        return new Route();
    }
}