<?php namespace Maduser\Minimal\Base\Factories;

use Maduser\Minimal\Base\Factories\MinimalFactory;
use Maduser\Minimal\Base\Interfaces\ModuleInterface;

class ModuleFactory extends MinimalFactory
{
    public function create($class, array $params = null) : ModuleInterface
    {
        return parent::createInstance($class, $params);
    }
}