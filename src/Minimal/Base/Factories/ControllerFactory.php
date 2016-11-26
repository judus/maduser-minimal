<?php namespace Maduser\Minimal\Base\Factories;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Factories\MinimalFactory;
use Maduser\Minimal\Base\Interfaces\ControllerFactoryInterface;
use Maduser\Minimal\Base\Interfaces\ControllerInterface;

class ControllerFactory extends MinimalFactory implements ControllerFactoryInterface
{
    public function create($class, array $params = null) : ControllerInterface
    {
        //return parent::createInstance($class, $params);
        return $this->createInstance($class, $params);
    }

    public function createInstance($class, array $params = null)
    {
        // Do we have a provider? We're finished if true
        if (is_string($class)) {

            // Test full qualified name
            if (IOC::registered($class)) {
                return IOC::resolve($class);
            }

            // Test alias
            $classAlias = str_replace($this->namespace, '', $class);
            if (IOC::registered($classAlias)) {
                return IOC::resolve($classAlias);
            }
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
                $aliasImplementation = str_replace($this->namespace, '',
                    $implementation);

                if (IOC::registered($implementation)) {
                    $implementation = IOC::resolve($implementation);
                } else {
                    if (IOC::registered($aliasImplementation)) {
                        $implementation = IOC::resolve($aliasImplementation);
                    } else {
                        $implementation = new $implementation();
                    }
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
}