<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Facades\IOC;

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
        if (IOC::hasSingleton($name)) {
            return IOC::singleton($name);
        } else {
            IOC::singleton($name, $object);
            return $object;
        }
    }

}