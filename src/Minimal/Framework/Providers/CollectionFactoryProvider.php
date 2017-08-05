<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Framework\Factories\CollectionFactory;

/**
 * Class CollectionFactoryProvider
 *
 * @package Maduser\Minimal\Providers
 */
class CollectionFactoryProvider extends AbstractProvider
{
    /**
     * @return CollectionFactory
     */
    public function resolve()
    {
        return new CollectionFactory();
    }
}