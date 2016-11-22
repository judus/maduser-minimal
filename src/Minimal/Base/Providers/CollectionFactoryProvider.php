<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Factories\CollectionFactory;

class CollectionFactoryProvider extends Provider
{
    public function resolve()
    {
        return new CollectionFactory();
    }
}