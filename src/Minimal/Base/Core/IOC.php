<?php namespace Maduser\Minimal\Base\Core;

/**
 * Class IOC
 *
 * @package Minimal\Base\Core
 */
class IOC {

	/**
	 * @var array
	 */
	public static $registry = array();

	/**
	 * @param                  $name
	 * @param \Closure|Closure $resolve
	 */
	public static function register($name, \Closure $resolve)
	{
		static::$registry[$name] = $resolve;
	}

	/**
	 * @param $name
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public static function resolve($name)
	{
		if ( static::registered($name) )
		{
			$name = static::$registry[$name];
			return $name();
		}

		throw new \Exception("IOC could not resolve '".$name."'.");
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