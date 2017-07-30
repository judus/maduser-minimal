<?php namespace Maduser\Minimal\Controllers;


use Maduser\Minimal\Providers\Provider;

class ControllerFactoryProvider extends Provider
{
    public function resolve()
    {
        return new ControllerFactory();
    }
}