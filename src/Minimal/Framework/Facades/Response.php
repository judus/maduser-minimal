<?php namespace Maduser\Minimal\Framework\Facades;

use Maduser\Minimal\Http\Contracts\ResponseInterface;

class Response extends Facade
{
    protected static $instance;

    /**
     * @param $content
     *
     * @return mixed
     */
    public static function setContent($content)
    {
        return self::call();
    }

    /**
     * @return mixed
     */
    public static function getContent()
    {
        return self::call();
    }

    /**
     * @return mixed
     */
    public static function getJsonEncodeArray()
    {
        return self::call();
    }
    
    /**
     * @param mixed $jsonEncodeArray
     *
     * @return ResponseInterface
     */
    public static function setJsonEncodeArray($jsonEncodeArray): ResponseInterface
    {
        return self::call();
    }

    /**
     * @return mixed
     */
    public static function getJsonEncodeObject()
    {
        return self::call();
    }
    
    /**
     * @param mixed $jsonEncodeObject
     *
     * @return $this
     */
    public static function setJsonEncodeObject($jsonEncodeObject)
    {
        return self::call();
    }

    /**
     * Send a http header
     *
     * @param $str
     *
     * @return $this
     */
    public static function header($str)
    {
        return self::call();
    }
    
    /**
     * @param null $content
     *
     * @return $this
     */
    public static function prepare($content = null)
    {
        return self::call();
    }
    
    /**
     * Prepares and send the response to the client
     *
     * @param null $content
     *
     * @return $this
     */
    public static function send($content = null)
    {
        return self::call();
    }

    /**
     * Send the response to the client
     *
     * @return $this
     */
    public static function sendPrepared()
    {
        return self::call();
    }

    /**
     * Encode array to json if configured
     *
     * @param $content
     *
     * @return string
     */
    public static function arrayToJson($content = null)
    {
        return self::call();
    }
    
    /**
     * Encode object to json if configured
     *
     * @param $content
     *
     * @return string
     */
    public static function objectToJson($content = null)
    {
        return self::call();
    }
    
    /**
     * Does a print_r with objects and array recursive
     *
     * @param $content
     *
     * @return string
     */
    public static function printRecursiveNonAlphaNum($content = null)
    {
        return self::call();
    }
    
    /**
     * Redirect location
     *
     * @param $url
     *
     * @return mixed
     */
    public static function redirect($url)
    {
        return self::call();
    }

    /**
     * Sends a 404 Error message
     */
    public static function status404()
    {
        return self::call();
    }

    /**
     * Exit PHP
     */
    public static function terminate()
    {
        return self::call();
    }
}