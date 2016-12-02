<?php namespace Maduser\Minimal\Base\Factories;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Factories\MinimalFactory;
use Maduser\Minimal\Base\Interfaces\ControllerFactoryInterface;
use Maduser\Minimal\Base\Interfaces\ControllerInterface;

/**
 * Class ControllerFactory
 *
 * @package Maduser\Minimal\Base\Factories
 */
class ControllerFactory extends MinimalFactory implements ControllerFactoryInterface
{
    /**
     * @param            $class
     * @param array|null $params
     *
     * @return mixed|object
     */
    public function createInstance($class, array $params = null)
    {
        // Do we have a provider? We're finished if true
        // TODO: find out why $class is not always a string
        if (is_string($class) && IOC::registered($class)) {
            return IOC::resolve($class);
        }

        return IOC::make($class, $params);
    }
}