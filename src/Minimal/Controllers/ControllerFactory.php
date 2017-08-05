<?php namespace Maduser\Minimal\Controllers;

use Maduser\Minimal\Factories\MinimalFactory;
use Maduser\Minimal\Facades\IOC;
use Maduser\Minimal\Services\Exceptions\IocNotResolvableException;

/**
 * Class ControllerFactory
 *
 * @package Maduser\Minimal\Factories
 */
class ControllerFactory extends MinimalFactory implements ControllerFactoryInterface
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