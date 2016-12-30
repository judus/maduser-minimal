<?php namespace Maduser\Minimal\Factories;

use Maduser\Minimal\Core\Collection;
use Maduser\Minimal\Core\IOC;
use Maduser\Minimal\Interfaces\CollectionFactoryInterface;
use Maduser\Minimal\Interfaces\CollectionInterface;

/**
 * Class CollectionFactory
 *
 * @package Maduser\Minimal\Factories
 */
class CollectionFactory implements CollectionFactoryInterface
{
    /**
     * @param array|null $params
     * @param null       $class
     *
     * @return CollectionInterface
     */
    public function create(array $params = null, $class = null): CollectionInterface
    {
        return IOC::make(Collection::class, $params);
    }
}