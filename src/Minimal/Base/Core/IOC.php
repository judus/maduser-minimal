<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Exceptions\ClassDoesNotExistException;
use Maduser\Minimal\Base\Exceptions\IocNotResolvableException;
use Maduser\Minimal\Base\Exceptions\MinimalException;
use Maduser\Minimal\Base\Exceptions\UnresolvedDependenciesException;

/**
 * Class IOC
 *
 * @package Maduser\Maduser\Minimal\Base\Core
 */
class IOC
{
    /**
     * @var string
     */
    private static $namespace = "Maduser\\Minimal\\Base\\Core\\";

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
        if ($name = static::registered($name)) {
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
        if (array_key_exists($name, static::$registry)) {
            return $name;
        }

        $alias = str_replace(self::$namespace, '', $name);

        if (array_key_exists($alias, static::$registry)) {
            return $alias;
        }

        return null;
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

    public static function reflect($class)
    {
        try {
            return new \ReflectionClass($class);
        } catch (\Exception $e) {
            throw new ClassDoesNotExistException('Class '. $class.' does not exist');
        }
    }

    public static function getDependencies($reflected)
    {
        $dependencies = [];

        if ($constructor = $reflected->getConstructor()) {
            $parameters = $constructor->getParameters();
            foreach ($parameters as $parameter) {
                $dependencies[] = self::getDependency($parameter);
            }
        }
        return $dependencies;
    }

    public static function getDependency($parameter)
    {
        $class = $parameter->getClass()->name;

        $reflected = new \ReflectionClass($class);

        if (self::binded($reflected->name)) {
            return self::$bindings[$reflected->name];
        } else {
            return$reflected->name;
        }
    }

    public static function resolveDependencies(array $dependencies)
    {
        foreach ($dependencies as &$dependency) {
            if (IOC::registered($dependency)) {
                $dependency = IOC::resolve($dependency);
            } else {
                // just try unregistered
                $dependency = new $dependency();
            }
        }
        return $dependencies;
    }

    public static function make($class, array $params = null)
    {
        $reflected = self::reflect($class);

        $dependencies = self::getDependencies($reflected);

        $instanceArgs = self::resolveDependencies($dependencies);

        if (count($dependencies) != count($instanceArgs)) {
            throw new UnresolvedDependenciesException(
                'Could not resolve all dependencies', [
                'Required' => $dependencies,
                'Resolved' => $instanceArgs
            ]);
        }

        if (is_array($params)) {
            $instanceArgs = array_merge($instanceArgs, $params);
        }

        return $reflected->newInstanceArgs($instanceArgs);
    }

}
