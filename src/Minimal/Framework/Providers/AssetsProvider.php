<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Assets\Assets;

/**
 * Class AssetsProvider
 *
 * @package Maduser\Minimal\Providers
 */
class AssetsProvider extends AbstractProvider
{
    /**
     * @return \Maduser\Minimal\Assets\Assets
     */
    public function resolve()
    {
        return $this->singleton('Assets', new Assets());
    }
}