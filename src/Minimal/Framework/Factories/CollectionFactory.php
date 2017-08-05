<?php namespace Maduser\Minimal\Framework\Factories;

use Maduser\Minimal\Collections\Collection;
use Maduser\Minimal\Collections\Contracts\CollectionInterface;
use Maduser\Minimal\Framework\Facades\IOC;
use Maduser\Minimal\Framework\Factories\Contracts\CollectionFactoryInterface;

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