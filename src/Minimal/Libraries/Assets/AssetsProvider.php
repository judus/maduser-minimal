<?php namespace Maduser\Minimal\Libraries\Assets;

use Maduser\Minimal\Providers\Provider;
use Maduser\Minimal\Libraries\Assets\Assets;

/**
 * Class AssetsProvider
 *
 * @package Maduser\Minimal\Libraries\Assets
 */
class AssetsProvider extends Provider
{
    /**
     * @return \Maduser\Minimal\Libraries\Assets\Assets
     */
    public function resolve()
    {
        return $this->singleton('Assets', new Assets());
    }
}