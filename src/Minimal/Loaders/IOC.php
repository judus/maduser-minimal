<?php namespace Maduser\Minimal\Loaders;

/**
 * Class IOC
 *
 * @package Maduser\Maduser\Minimal\Loaders
 */
class IOC
{
    /**
     * @var string
     */
    private static $namespace = "Maduser\\Minimal\\Core\\";

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

    /**
     * @var array
     */
    public static $config = [];


    public static function config(string $key, array $array = null)
    {
        if (is_array($array) && !isset(static::$config[$key])) {
            static::$config[$key] = $array;
        } else {
            return static::$config[$key];
        }
    }

    /**
     * @return string
     */
    public static function getNamespace(): string
    {
        return self::$namespace;
    }

    /**
     * @param string $namespace
     */
    public static function setNamespace(string $namespace)
    {
        self::$namespace = $namespace;
    }


    /**
     * @param          $name
     * @param \Closure $class
     */
    public static function register($name, \Closure $class)
    {
        static::$registry[$name] = $class;
    }

    /**
     * @param          $name
     * @param \Closure $singleton
     */
    public static function singleton($name, \Closure $singleton)
    {
        static::$registry[$name] = $singleton();
    }

    /**
     * @param $name
     * @param $binding
     */
    public static function bind($name, $binding)
    {
        static::$bindings[$name] = $binding;
    }

    /**
     * @param          $name
     * @param \Closure $provider
     */
    public static function provide($name, \Closure $provider)
    {
        static::$registry[$name] = $provider;
    }

    /**
     * @param      $name
     * @param null $params
     *
     * @return mixed
     * @throws IocNotResolvableException
     */
    public static function resolve($name, $params = null)
    {
        $_name = $name;

        if ($name = static::registered($name)) {
            $name = static::$registry[$name];
            return $name()->resolve($params);
        }


        throw new IocNotResolvableException($_name, [
            'name' => $name,
            'params' => $params,
            'trace' => debug_backtrace(),
            'registry' => static::$registry,
        ]);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public static function registered($name, $debug = false)
    {
        !$debug || d(static::$registry, 'Looking in registry for ' . $name);

        if (array_key_exists($name, static::$singletons)) {
            return $name;
        }

        if (array_key_exists($name, static::$registry)) {
            return $name;
        }

        //$alias = str_replace(self::$namespace, '', $name);
        $alias = basename(str_replace('\\', '/', $name));

        if (array_key_exists($alias, static::$singletons)) {
            return $alias;
        }

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
    public static function bound($name)
    {
        return array_key_exists($name, static::$bindings);
    }

    /**
     * @param $class
     *
     * @return \ReflectionClass
     * @throws ClassDoesNotExistException
     */
    public static function reflect($class)
    {
        try {
            return new \ReflectionClass($class);
        } catch (\Exception $e) {
            throw new ClassDoesNotExistException('Class '. $class.' does not exist');
        }
    }

    /**
     * @param \ReflectionClass $reflected
     *
     * @return array
     */
    public static function getDependencies(\ReflectionClass $reflected)
    {
        $dependencies = [];

        if ($constructor = $reflected->getConstructor()) {
            $parameters = $constructor->getParameters();
            foreach ($parameters as $parameter) {
                $dependencies[] = self::getDependency($parameter, $reflected,
                    $parameters);
            }
        }
        return $dependencies;
    }

    /**
     * @param \ReflectionParameter $parameter
     *
     * @return mixed|null
     */
    public static function getDependency(\ReflectionParameter $parameter, \ReflectionClass $reflected, $parameters)
    {
/*
        if (!$parameter->isCallable()) {
            throw new IocNotResolvableException('Class does not exist', [
                'Reflected class' => $reflected,
                'Constructor params' => $parameters
            ]);
        }
*/
        if ($parameter->isArray() || !$parameter->getClass()) {
            return null;
        }

        $class = $parameter->getClass()->name;

        if ($class == 'Closure') {
            return null;
        }

        $reflected = new \ReflectionClass($class);

        if (self::bound($reflected->name)) {
            return self::$bindings[$reflected->name];
        } else {
            return $reflected->name;
        }
    }

    /**
     * @param array $dependencies
     *
     * @return array
     */
    public static function resolveDependencies(array $dependencies, $debug = false)
    {
        //show($dependencies);
        foreach ($dependencies as &$dependency) {
            if (is_null($dependency)) {
                $dependency =  null;
            } else {
                if (IOC::registered($dependency, $debug)) {
                    $dependency = IOC::resolve($dependency);
                } else {
                    // just try unregistered
                    $dependency = IOC::make($dependency);
                }
            }
        }
        return $dependencies;
    }

    /**
     * @param            $class
     * @param array|null $params
     *
     * @return object
     * @throws IocNotResolvableException
     * @throws UnresolvedDependenciesException
     */
    public static function make($class, array $params = null, $debug = false)
    {
        $reflected = self::reflect($class);

        if (empty($reflected->getConstructor())) {

            if ($reflected->isInterface()) {
                throw new IocNotResolvableException('Cannot instantiate ' . $reflected->getName());
            }
            return $reflected->newInstance();
        }

        $dependencies = self::getDependencies($reflected);

        !$debug || d($dependencies);

        $instanceArgs = self::resolveDependencies($dependencies, $debug);

        !$debug || d($instanceArgs);

        if (is_array($params)) {
            foreach($params as $param) {
                foreach ($instanceArgs as &$instanceArg) {
                    if (is_null($instanceArg)) {
                        $instanceArg = $param;
                        break;
                    }
                }
            }
        }

        // TODO: Improve this. A lot.
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
