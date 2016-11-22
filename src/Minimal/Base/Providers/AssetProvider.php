<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\Asset;

class AssetProvider extends Provider
{
    public function resolve()
    {
        return new Asset();
    }
}