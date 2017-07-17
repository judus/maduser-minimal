<?php namespace Maduser\Minimal\Collections;

use Maduser\Minimal\Providers\Provider;

/**
 * Class CollectionFactoryProvider
 *
 * @package Maduser\Minimal\Providers
 */
class CollectionFactoryProvider extends Provider
{
    /**
     * @return CollectionFactory
     */
    public function resolve()
    {
        return new CollectionFactory();
    }
}