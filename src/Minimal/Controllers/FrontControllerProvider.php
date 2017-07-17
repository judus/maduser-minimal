<?php namespace Maduser\Minimal\Controllers;

use Maduser\Minimal\Loaders\IOC;
use Maduser\Minimal\Providers\Provider;

class FrontControllerProvider extends Provider
{
    public function resolve()
    {
        return new FrontController(
            IOC::resolve('Router'),
            IOC::resolve('Response'),
            IOC::resolve('ModelFactory'),
            IOC::resolve('ViewFactory'),
            IOC::resolve('ControllerFactory')
        );
    }
}