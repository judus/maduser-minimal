<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Factories\ControllerFactory;

class ControllerFactoryProvider extends Provider
{
    public function resolve()
    {
        return new ControllerFactory();
    }
}