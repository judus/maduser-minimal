<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Factories\ControllerFactory;

class ControllerFactoryProvider extends Provider
{
    public function resolve()
    {
        return new ControllerFactory();
    }
}