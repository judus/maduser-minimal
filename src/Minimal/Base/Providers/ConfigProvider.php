<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Core\Config;

class ConfigProvider extends Provider
{
    public function resolve()
    {
        return $this->singleton('Config', new Config());
    }
}