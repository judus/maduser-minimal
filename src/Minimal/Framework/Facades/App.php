<?php namespace Maduser\Minimal\Framework\Facades;

use Maduser\Minimal\Framework\Minimal as Implementation;

/**
 * Class App
 *
 * @package Maduser\Minimal\Framework\Facades
 */
class App extends Facade
{
    protected static $instance;

    public static function setInstance($instance)
    {
        self::$instance = $instance;
    }

    /**
     * @param            $class
     * @param array|null $options
     *
     * @return Implementation
     */
    protected static function makeInstance(
        $class,
        array $options = null
    ): Implementation {
        // TODO: get rid of $_SERVER
        $options || $options = [
            'path' => realpath($_SERVER['DOCUMENT_ROOT'] . '/../') . '/'
        ];

        return IOC::make($class, [$options, true]);
    }

    /**
     * @param null  $class
     * @param array $options
     *
     * @return Implementation
     */
    public static function getInstance(
        $class = null,
        array $options = []
    ): Implementation {

        /** @var Implementation $instance */
        if (is_null(self::$instance)) {
            if (is_null($class)) {
                self::$instance = self::makeInstance(
                    Implementation::class, $options
                );

                self::$instance->load();

            } else {
                ! is_object($class) || self::$instance = $class;
            }
        }

        return self::$instance;
    }

    /**
     * @param null  $uri
     *
     * @return $this
     */
    public static function run($uri = null)
    {
        return self::getInstance()->execute($uri)->getResult();
    }

    /**
     * @param array         $options
     * @param \Closure|null $closure
     * @param null          $class
     */
    public static function respond(
        $options = [],
        $closure = null,
        $class = null
    ) {
        if (is_callable($options)) {
            $_closure = $options;
            $_options = $closure;
        } else {
            $_closure = $closure;
            $_options = $options;
        }

        is_array($_options) || $_options = [];

        /** @var Implementation $app */
        self::getInstance($class, $_options);

        is_null($_closure) || $_closure();

        self::getInstance()->execute()->respond()->terminate();
    }
}