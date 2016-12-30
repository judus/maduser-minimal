<?php namespace Maduser\Minimal\Factories;

use Maduser\Minimal\Core\IOC;
use Maduser\Minimal\Core\Module;
use Maduser\Minimal\Factories\MinimalFactory;
use Maduser\Minimal\Interfaces\ModuleFactoryInterface;
use Maduser\Minimal\Interfaces\ModuleInterface;

class ModuleFactory extends MinimalFactory implements ModuleFactoryInterface
{
    public function create(array $params = null, $class = null) : ModuleInterface
    {
        return IOC::make(Module::class, $params);
    }
}