<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Core\Modules;

class ModulesProvider extends Provider
{
    public function resolve()
    {
        return new Modules(
            IOC::resolve('Config'),
            IOC::resolve('CollectionFactory'),
            IOC::resolve('Collection'),
            IOC::resolve('ModuleFactory'),
            IOC::resolve('Module'),
            IOC::resolve('Request'),
            IOC::resolve('Response'),
            IOC::resolve('Router')
        );
    }
}