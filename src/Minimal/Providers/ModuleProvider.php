<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Core\IOC;
use Maduser\Minimal\Core\Module;

class ModuleProvider extends Provider
{
    public function resolve()
    {
        return new Module(
            IOC::resolve('CollectionFactory'),
            IOC::resolve('Collection')
        );
    }
}