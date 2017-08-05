<?php namespace Maduser\Minimal\Apps;

use Maduser\Minimal\Facades\IOC;
use Maduser\Minimal\Providers\Provider;

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