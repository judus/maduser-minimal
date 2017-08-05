<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Config\Config;

/**
 * Class ConfigProvider
 *
 * @package Maduser\Minimal\Providers
 */
class ConfigProvider extends AbstractProvider
{
    /**
     * @return mixed
     */
    public function resolve()
    {
        return $this->singleton('Config', new Config());
    }
}