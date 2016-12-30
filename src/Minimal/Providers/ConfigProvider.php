<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Core\IOC;
use Maduser\Minimal\Core\Config;

class ConfigProvider extends Provider
{
    public function resolve()
    {
        return $this->singleton('Config', new Config());
    }
}