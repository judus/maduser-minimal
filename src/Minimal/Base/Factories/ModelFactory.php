<?php namespace Maduser\Minimal\Base\Factories;

use Maduser\Minimal\Base\Factories\MinimalFactory;
use Maduser\Minimal\Base\Interfaces\ModelFactoryInterface;
use Maduser\Minimal\Base\Interfaces\ModelInterface;

class ModelFactory extends MinimalFactory implements ModelFactoryInterface
{
    public function create($class, array $params = null) : ModelInterface
    {
        return parent::createInstance($class, $params);
    }
}