<?php namespace Maduser\Minimal\Base\Factories;

use Maduser\Minimal\Base\Factories\MinimalFactory;
use Maduser\Minimal\Base\Interfaces\CollectionFactoryInterface;
use Maduser\Minimal\Base\Interfaces\CollectionInterface;

class CollectionFactory extends MinimalFactory implements CollectionFactoryInterface
{
    public function create($class, array $params = null) : CollectionInterface
    {
        return parent::createInstance($class, $params);
    }
}