<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Loaders\IOC;

/**
 * Class Provider
 *
 * @package Maduser\Minimal\Providers
 */
class Provider implements ProviderInterface
{
    /**
     * Provider constructor.
     */
    public function __construct()
    {
        return $this;
    }

    /**
     *
     */
    public function init()
    {

    }

    /**
     *
     */
    public function register()
    {

    }

    /**
     *
     */
    public function resolve()
    {

    }

    /**
     * @param $name
     * @param $object
     *
     * @return mixed
     */
    public function singleton($name, $object)
    {
        if (isset(IOC::$singletons[$name])) {
            return IOC::$singletons[$name];
        } else {
            IOC::$singletons[$name] = $object;
            return $object;
        }
    }

}