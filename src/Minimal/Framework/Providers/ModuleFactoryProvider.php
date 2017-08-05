<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Framework\Factories\ModuleFactory;

/**
 * Class ModuleFactoryProvider
 *
 * @package Maduser\Minimal\Providers
 */
class ModuleFactoryProvider extends AbstractProvider
{
    /**
     * @return ModuleFactory
     */
    public function resolve()
    {
        return new ModuleFactory();
    }
}