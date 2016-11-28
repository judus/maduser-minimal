<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Exceptions\IocNotResolvableException;
use Maduser\Minimal\Base\Exceptions\MinimalException;

/**
 * Class IOC
 *
 * @package Maduser\Maduser\Minimal\Base\Core
 */
class IOC
{

    /**
     * @var array
     */
    public static $registry = [];

    /**
     * @var array
     */
    public static $singletons = [];

    /**
     * @var array
     */
    public static $bindings = [];

    /**
     * @var array
     */
    public static $providers = [];


    public static function register($name, \Closure $class)
    {
        static::$registry[$name] = $class;
    }

    public static function singleton($name, \Closure $singleton)
    {
        static::$registry[$name] = $singleton();
    }

    public static function bind($name, $binding)
    {
        static::$bindings[$name] = $binding;
    }

    public static function provide($name, \Closure $provider)
    {
        static::$registry[$name] = $provider;
    }

    /**
     * @param $name
     *
     * @return mixed
     * @throws \Exception
     */
    public static function resolve($name)
    {
        if (static::registered($name)) {
            $name = static::$registry[$name];
            return $name()->resolve();
        }
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public static function registered($name)
    {
        return array_key_exists($name, static::$registry);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public static function binded($name)
    {
        return array_key_exists($name, static::$bindings);
    }
}
