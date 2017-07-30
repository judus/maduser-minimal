<?php namespace Maduser\Minimal\Controllers;

use Maduser\Minimal\Factories\MinimalFactory;
use Maduser\Minimal\Loaders\IOC;
use Maduser\Minimal\Loaders\IocNotResolvableException;

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

        try {
            return IOC::make($class, $params, false);

        } catch (\Exception $e) {
            throw new IocNotResolvableException('ControllerFactory could not create class ' . $class,
                $e);
        }
    }
}