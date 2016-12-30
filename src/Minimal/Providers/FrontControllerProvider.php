<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Core\FrontController;
use Maduser\Minimal\Core\IOC;

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