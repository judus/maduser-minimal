<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Framework\Module;
use Maduser\Minimal\Framework\Facades\IOC;

/**
 * Class ModuleProvider
 *
 * @package Maduser\Minimal\Providers
 */
class ModuleProvider extends AbstractProvider
{
    /**
     * @return Module
     */
    public function resolve()
    {
        return new Module(
            IOC::resolve('CollectionFactory'),
            IOC::resolve('Collection')
        );
    }
}