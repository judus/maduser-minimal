<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Factories\CollectionFactory;

class CollectionFactoryProvider extends Provider
{
    public function resolve()
    {
        return new CollectionFactory();
    }
}