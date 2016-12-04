<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Core\Modules;

class ModulesProvider extends Provider
{
    public function resolve()
    {
        return $this->singleton('Modules', new Modules(
            IOC::resolve('Config'),
            IOC::resolve('CollectionFactory'),
            IOC::resolve('ModuleFactory'),
            IOC::resolve('Request'),
            IOC::resolve('Response'),
            IOC::resolve('Router')
       ));
    }
}