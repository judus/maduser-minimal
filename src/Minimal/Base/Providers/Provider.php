<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Interfaces\ProviderInterface;

/**
 * Class Provider
 *
 * @package Maduser\Minimal\Base\Providers
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