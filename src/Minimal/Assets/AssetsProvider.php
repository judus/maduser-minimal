<?php namespace Maduser\Minimal\Assets;

use Maduser\Minimal\Providers\Provider;

/**
 * Class AssetsProvider
 *
 * @package Maduser\Minimal\Assets
 */
class AssetsProvider extends Provider
{
    /**
     * @return \Maduser\Minimal\Assets\Assets
     */
    public function resolve()
    {
        return $this->singleton('Assets', new Assets());
    }
}