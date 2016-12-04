<?php namespace Maduser\Minimal\Base\Factories;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Core\Module;
use Maduser\Minimal\Base\Factories\MinimalFactory;
use Maduser\Minimal\Base\Interfaces\ModuleFactoryInterface;
use Maduser\Minimal\Base\Interfaces\ModuleInterface;

class ModuleFactory extends MinimalFactory implements ModuleFactoryInterface
{
    public function create(array $params = null, $class = null) : ModuleInterface
    {
        return IOC::make(Module::class, $params);
    }
}