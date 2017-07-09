<?php namespace Maduser\Minimal\Cli;

class Cli
{
    public function __construct($args = [], $minimal)
    {
        if (count($args) > 0) {
            $params = isset($args[1]) ? array_slice($args, 1) : [];
            $this->execute($args[0], [$minimal] + $params);
        }

    }

    private function execute($class, $params)
    {
        $method = null;

        if (preg_match('/::/', $class)) {
            list($class, $method) = explode('::', $class);
        }

        $class = __NAMESPACE__ . '\\' . ucfirst($class);

        if ($object = $this->createInstance($class, $params)) {
            if (!is_null($method)) {
                if (!method_exists($object, $method)) {
                    die('Method "' . $method . '" does not exist in class "' . $class . '".');
                }
                call_user_func_array([$object, $method], $params);
            }
        } else {
            die('Class "' . $class . '" not found.');
        }
    }

    private function createInstance($class, $args = array())
    {
        if (class_exists($class)) {
            $reflection = new \ReflectionClass($class);
            if ($reflection->getConstructor()) {
                return $reflection->newInstanceArgs($args);
            } else {
                return $reflection->newInstance();
            }

        }

        return null;
    }
}