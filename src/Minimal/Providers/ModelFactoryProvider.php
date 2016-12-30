<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Core\IOC;
use Maduser\Minimal\Factories\ModelFactory;

class ModelFactoryProvider extends Provider
{
    public function resolve()
    {
        return new ModelFactory(
            IOC::resolve('Router'),
            IOC::resolve('Response'),
            IOC::resolve('ModelFactory'),
            IOC::resolve('ViewFactory'),
            IOC::resolve('ControllerFactory')
        );
    }
}