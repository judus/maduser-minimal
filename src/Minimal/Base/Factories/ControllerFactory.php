<?php namespace Maduser\Minimal\Base\Factories;

use Maduser\Minimal\Base\Factories\MinimalFactory;
use Maduser\Minimal\Base\Interfaces\ControllerFactoryInterface;
use Maduser\Minimal\Base\Interfaces\ControllerInterface;

class ControllerFactory extends MinimalFactory implements ControllerFactoryInterface
{
    public function create($class, array $params = null) : ControllerInterface
    {
        return parent::createInstance($class, $params);
    }
}