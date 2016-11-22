<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\FrontController;
use Maduser\Minimal\Base\Core\IOC;

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