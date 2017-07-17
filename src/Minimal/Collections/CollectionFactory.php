<?php namespace Maduser\Minimal\Collections;

use Maduser\Minimal\Collections\Collection;
use Maduser\Minimal\Collections\CollectionFactoryInterface;
use Maduser\Minimal\Collections\CollectionInterface;
use Maduser\Minimal\Loaders\IOC;


/**
 * Class CollectionFactory
 *
 * @package Maduser\Minimal\Collections
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