<?php namespace Maduser\Minimal\Facades;

use Maduser\Minimal\Database\Connectors\PDO as Instance;

class PDO extends Facade
{
    /**
     * @var
     */
    protected static $instance;

    /**
     * @return Instance
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = Instance::class;
        }

        return static::$instance;
    }

    public static function connection(array $dbCredentials = [])
    {
        return self::call();
    }
}