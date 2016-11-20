<?php namespace Maduser\Minimal\Base\Factories;

use Maduser\Minimal\Base\Interfaces\MinimalFactoryInterface;

/**
 * Class MinimalFactory
 *
 * @package Maduser\Minimal\Base\Factories
 */
class MinimalFactory implements MinimalFactoryInterface
{
    /**
     * @param       $class
     * @param array $params
     *
     * @return mixed
     */
    public function createInstance($class, array $params = null)
    {
        $params = $params ? $params : [];

        $reflected = new \ReflectionClass($class);

        return $reflected->newInstanceArgs($params);
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
