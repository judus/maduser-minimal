<?php namespace Maduser\Minimal\Collections;

use Maduser\Minimal\Providers\Provider;

/**
 * Class CollectionProvider
 *
 * @package Maduser\Minimal\Providers
 */
class CollectionProvider extends Provider
{
    /**
     * @return Collection
     */
    public function resolve()
    {
        return new Collection();
    }
}