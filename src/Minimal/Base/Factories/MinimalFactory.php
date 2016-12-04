<?php namespace Maduser\Minimal\Base\Factories;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Interfaces\MinimalFactoryInterface;

/**
 * Class MinimalFactory
 *
 * @package Maduser\Minimal\Base\Factories
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
