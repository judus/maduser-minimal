<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\Assets;

class AssetsProvider extends Provider
{
    public function resolve()
    {
        return $this->singleton('Assets', new Assets());
    }
}