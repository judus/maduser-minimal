<?php namespace Maduser\Minimal\Apps;

use Maduser\Minimal\Loaders\IOC;
use Maduser\Minimal\Factories\MinimalFactory;

class ModuleFactory extends MinimalFactory implements ModuleFactoryInterface
{
    public function create(array $params = null, $class = null) : ModuleInterface
    {
        return IOC::make(Module::class, $params);
    }
}