<?php namespace Maduser\Minimal\Apps;


use Maduser\Minimal\Loaders\IOC;
use Maduser\Minimal\Providers\Provider;

class FactoryProvider extends Provider
{
    public function resolve()
    {
        return $this->singleton('Factory', new Factory(
            IOC::resolve('Config'),
            IOC::resolve('CollectionFactory'),
            IOC::resolve('ModuleFactory')
        ));
    }
}