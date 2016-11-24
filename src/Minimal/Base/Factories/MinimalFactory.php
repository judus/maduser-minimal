<?php namespace Maduser\Minimal\Base\Factories;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Exceptions\UnresolvedDependenciesException;
use Maduser\Minimal\Base\Interfaces\MinimalFactoryInterface;

/**
 * Class MinimalFactory
 *
 * @package Maduser\Minimal\Base\Factories
 */
class MinimalFactory implements MinimalFactoryInterface
{
    protected $namespace = "Maduser\\Minimal\\Base\\Core\\";

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param       $class
     * @param array $params
     *
     * @return mixed
     */
    public function createInstance($class, array $params = null)
    {
        // Do we have a provider? We're finished if true
        if (is_string($class) && IOC::registered($class)) {
            return IOC::resolve($class);
        }

        // Do we have a binding? for the class $params
        $reflected = new \ReflectionClass($class);
        $found = [];

        if ($constructor = $reflected->getConstructor()) {
            $dependencies = $constructor->getParameters();
            foreach ($dependencies as $dependency) {
                $dependencyClass = $dependency->getClass()->name;
                $reflectedDependency = new \ReflectionClass($dependencyClass);

                if (IOC::binded($reflectedDependency->name)) {
                    $found[] = IOC::$bindings[$reflectedDependency->name];
                } else {
                    $found[] = $reflectedDependency->name;
                }
            }


            foreach ($found as &$implementation) {
                $aliasImplementation = str_replace($this->namespace, '', $implementation);

                if (IOC::registered($implementation)) {
                    $implementation = IOC::resolve($implementation);
                } else if (IOC::registered($aliasImplementation)) {
                    $implementation = IOC::resolve($aliasImplementation);
                } else {
                    $implementation = new $implementation();
                }
            }

            if (count($dependencies) != count($found)) {
                throw new UnresolvedDependenciesException(
                    'Could not resolve all required dependencies', [
                    'Required dependencies' => $dependencies,
                    'Found implementations' => $found
                ]);
            }
        }

        return $reflected->newInstanceArgs($found);
    }


    public function fetchDependencies() {

    }

    /**
     * @param       $class
     * @param array $params
     *
     * @return mixed
     */
    public function create($class, array $params = null)
    {
        return $this->createInstance($class, $params);
    }
}
