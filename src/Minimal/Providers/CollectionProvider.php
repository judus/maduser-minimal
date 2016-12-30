<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Core\Collection;

class CollectionProvider extends Provider
{
    public function resolve()
    {
        return new Collection();
    }
}