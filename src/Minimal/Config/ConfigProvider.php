<?php namespace Maduser\Minimal\Config;

use Maduser\Minimal\Providers\Provider;

/**
 * Class ConfigProvider
 *
 * @package Maduser\Minimal\Config
 */
class ConfigProvider extends Provider
{
    /**
     * @return mixed
     */
    public function resolve()
    {
        return $this->singleton('Config', new Config());
    }
}