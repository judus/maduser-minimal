<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Factories\ModuleFactory;

class ModuleFactoryProvider extends Provider
{
    public function resolve()
    {
        return new ModuleFactory();
    }
}