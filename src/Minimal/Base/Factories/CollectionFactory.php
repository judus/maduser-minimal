<?php namespace Maduser\Minimal\Base\Factories;

use Maduser\Minimal\Base\Core\Collection;
use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Interfaces\CollectionFactoryInterface;
use Maduser\Minimal\Base\Interfaces\CollectionInterface;

/**
 * Class CollectionFactory
 *
 * @package Maduser\Minimal\Base\Factories
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