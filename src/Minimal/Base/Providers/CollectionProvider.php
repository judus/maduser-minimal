<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\Collection;

class CollectionProvider extends Provider
{
    public function resolve()
    {
        return new Collection();
    }
}