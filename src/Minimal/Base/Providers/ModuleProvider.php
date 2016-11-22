<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Core\Module;

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