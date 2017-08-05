<?php namespace Maduser\Minimal\Framework\Facades;

use Maduser\Minimal\Provider\Container;
use Maduser\Minimal\Provider\Provider as Implementation;

/**
 * Class Path
 *
 * @package Maduser\Minimal\Framework\Facades
 */
class IOC extends Facade
{

    /**
     * @var
     */
    protected static $instance;

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::getInstance()->{$name}($arguments);
    }

    /**
     * @return mixed
     */
    public static function call()
    {
        $name = debug_backtrace()[1]['function'];
        $arguments = debug_backtrace()[1]['args'];


        return call_user_func_array(
            [static::getInstance(), $name], $arguments);
    }

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            static::$instance = new Implementation();
        }

        return self::$instance;
    }

    /**
     * @return mixed
     */
    public static function getResolver()
    {
        return self::call();
    }

    /**
     * @return mixed
     */
    public static function getInjector()
    {
        return self::call();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function hasProvider($name)
    {
        return self::call();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function hasSingleton($name)
    {
        return self::call();
    }

    /**
     * @param      $name
     * @param null $object
     *
     * @return mixed
     */
    public static function singleton($name, $object = null)
    {
        return self::call();
    }

    /**
     * @param $providers
     *
     * @return mixed
     */
    public static function setProviders($providers)
    {
        return self::call();
    }

    /**
     * @param $providers
     *
     * @return mixed
     */
    public static function addProviders($providers)
    {
        return self::call();
    }

    /**
     * @param $bindings
     *
     * @return mixed
     */
    public static function setBindings($bindings)
    {
        return self::call();
    }

    /**
     * @param $bindings
     *
     * @return mixed
     */
    public static function addBindings($bindings)
    {
        return self::call();
    }

    /**
     * @return Container
     */
    public static function bindings()
    {
        return self::call();
    }

    /**
     * @return Container
     */
    public static function providers()
    {
        return self::call();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function getProvider($name)
    {
        return self::call();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function hasBinding($name)
    {
        return self::call();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function getBinding($name)
    {
        return self::call();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function resolve($name)
    {
        return self::call();
    }

    /**
     * @param      $name
     * @param null $params
     *
     * @return mixed
     */
    public static function make($name, $params = null)
    {
        return self::call();
    }

    /**
     * @param $name
     * @param $class
     *
     * @return mixed
     */
    public static function register($name, $class)
    {
        return self::call();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function registered($name)
    {
        return self::call();
    }

    /**
     * @param $name
     * @param $class
     *
     * @return mixed
     */
    public static function bind($name, $class)
    {
        return self::call();
    }

}