<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Framework\Facades\IOC;
use Maduser\Minimal\Provider\Contracts\AbstractProviderInterface;

/**
 * Class Provider
 *
 * @package Maduser\Minimal\Providers
 */
abstract class AbstractProvider implements AbstractProviderInterface
{
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