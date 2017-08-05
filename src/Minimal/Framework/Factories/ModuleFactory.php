<?php namespace Maduser\Minimal\Framework\Factories;

use Maduser\Minimal\Framework\Facades\IOC;
use Maduser\Minimal\Framework\Factories\Contracts\ModuleFactoryInterface;
use Maduser\Minimal\Framework\Contracts\ModuleInterface;
use Maduser\Minimal\Framework\Module;

class ModuleFactory extends MinimalFactory implements ModuleFactoryInterface
{
    public function create(array $params = null, $class = null) : ModuleInterface
    {
        return IOC::make(Module::class, $params);
    }
}