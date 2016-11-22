<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Factories\ModuleFactory;

class ModuleFactoryProvider extends Provider
{
    public function resolve()
    {
        return new ModuleFactory();
    }
}