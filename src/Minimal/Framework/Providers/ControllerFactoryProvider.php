<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Controllers\Factories\ControllerFactory;

/**
 * Class ControllerFactoryProvider
 *
 * @package Maduser\Minimal\Providers
 */
class ControllerFactoryProvider extends AbstractProvider
{
    /**
     * @return ControllerFactory
     */
    public function resolve()
    {
        return new ControllerFactory();
    }
}