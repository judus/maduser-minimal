<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Framework\Factory;
use Maduser\Minimal\Framework\Facades\IOC;

/**
 * Class FactoryProvider
 *
 * @package Maduser\Minimal\Providers
 */
class FactoryProvider extends AbstractProvider
{
    /**
     * @return mixed
     */
    public function resolve()
    {
        return $this->singleton('Factory', new Factory(
            IOC::resolve('Config'),
            IOC::resolve('CollectionFactory'),
            IOC::resolve('ModuleFactory')
        ));
    }
}