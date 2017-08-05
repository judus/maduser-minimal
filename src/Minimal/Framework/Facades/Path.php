<?php namespace Maduser\Minimal\Framework\Facades;

use Maduser\Minimal\Paths\PathGenerator as Implementation;

/**
 * Class Path
 *
 * @package Maduser\Minimal\Framework\Facades
 */
class Path
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
        if (is_null(static::$instance)) {
            self::$instance = new Implementation(
                Config::getInstance(),
                Request::getInstance()
            );
        }

        return self::$instance;
    }

    /**
     * @param      $name
     * @param bool $fromRoot
     *
     * @return mixed
     */
    public static function path($name, $fromRoot = true)
    {
        return self::call();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function http($name)
    {
        return self::call();
    }
}