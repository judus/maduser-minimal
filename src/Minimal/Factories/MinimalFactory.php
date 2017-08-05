<?php namespace Maduser\Minimal\Factories;

use Maduser\Minimal\Facades\IOC;

/**
 * Class MinimalFactory
 *
 * @package Maduser\Minimal\Apps
 */
abstract class MinimalFactory implements MinimalFactoryInterface
{
    public function create(array $params = null, $class = null)
    {
        // Do we have a provider? We're finished if true
        // TODO: find out why $class is not always a string
        if (is_string($class) && IOC::registered($class)) {
            return IOC::resolve($class);
        }

        return IOC::make($class, $params);
    }
}
