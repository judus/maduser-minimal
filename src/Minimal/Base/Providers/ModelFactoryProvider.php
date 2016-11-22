<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Factories\ModelFactory;

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