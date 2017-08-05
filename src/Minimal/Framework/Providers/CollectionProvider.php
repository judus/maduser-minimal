<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Collections\Collection;

/**
 * Class CollectionProvider
 *
 * @package Maduser\Minimal\Providers
 */
class CollectionProvider extends AbstractProvider
{
    /**
     * @return Collection
     */
    public function resolve()
    {
        return new Collection();
    }
}