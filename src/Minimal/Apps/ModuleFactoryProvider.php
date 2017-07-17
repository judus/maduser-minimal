<?php namespace Maduser\Minimal\Apps;

use Maduser\Minimal\Providers\Provider;

class ModuleFactoryProvider extends Provider
{
    public function resolve()
    {
        return new ModuleFactory();
    }
}