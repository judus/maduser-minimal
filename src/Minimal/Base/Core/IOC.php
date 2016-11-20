<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Exceptions\IocNotResolvableException;

/**
 * Class IOC
 *
 * @package Maduser\Maduser\Minimal\Base\Core
 */
class IOC {

    /**
     * @var array
     */
    public static $registry = array();

    /**
     * @var array
     */
    public static $singleton = array();

    /**
     * @param                  $name
     * @param \Closure|Closure $resolve
     * @param bool             $singleton
     */
	public static function register($name, \Closure $resolve, $singleton = false)
	{
        if ($singleton) {
            static::$registry[$name] = $resolve();
        } else {
            static::$registry[$name] = $resolve;
        }
	}

	/**
	 * @param $name
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public static function resolve($name)
	{
        try {
            if (static::registered($name)) {
                $name = static::$registry[$name];

                return is_callable($name) ? $name() : $name;
            }
        } catch (\Exception $e) {
            throw new IocNotResolvableException($e);
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
}