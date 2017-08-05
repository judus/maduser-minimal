<?php namespace Maduser\Minimal\Framework\Facades;

use Maduser\Minimal\Collections\Exceptions\InvalidKeyException;
use Maduser\Minimal\Collections\Exceptions\KeyInUseException;
use Maduser\Minimal\Collections\Exceptions\CollectionInterface;

class Collection extends Facade
{
    /**
     * @var
     */
    protected static $instance;

    /**
     * @return CollectionInterface
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = IOC::resolve('Collection');
        }

        return static::$instance;
    }/** @noinspection PhpUnusedParameterInspection */
    /** @noinspection PhpUnusedParameterInspection */
    /** @noinspection PhpUnusedParameterInspection */
    /** @noinspection PhpUnusedParameterInspection */

    /**
     * @param      $obj
     * @param null $key
     *
     * @return CollectionInterface
     * @throws KeyInUseException
     */
    public static function add($obj, $key = null): CollectionInterface
    {
        return self::call();
    }

    /**
     * @param $key
     *
     * @return mixed
     * @throws InvalidKeyException
     */
    public static function delete($key)
    {
        return self::call();
    }

    /**
     * @param $key
     *
     * @return mixed
     * @throws InvalidKeyException
     */
    public static function get($key)
    {
        return self::call();
    }

    /**
     * @param null $key
     *
     * @return int
     */
    public static function count($key = null)
    {
        return self::call();
    }

    /**
     * @return array
     */
    public static function getArray()
    {
        return self::call();
    }
}