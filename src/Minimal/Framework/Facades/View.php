<?php namespace Maduser\Minimal\Framework\Facades;

use Maduser\Minimal\Views\Exceptions\ViewNotFoundException;
use Maduser\Minimal\Views\View as Implementation;

class View
{
    /**
     * @var
     */
    protected static $instance;

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::getInstance()->{$name}($arguments);
    }

    /**
     * @return mixed
     */
    public static function call()
    {
        $name = debug_backtrace()[1]['function'];
        $arguments = debug_backtrace()[1]['args'];

        return call_user_func_array(
            [static::getInstance(), $name], $arguments);
    }

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            self::$instance = new Implementation();
        }

        return self::$instance;
    }
    
    /**
     * @return mixed
     */
    public static function getAssets()
    {
        return self::call();
    }


    /**
     * @param mixed $assets
     */
    public static function setAssets($assets)
    {
        self::call();
    }

    /**
     * @return mixed
     */
    public static function getDir()
    {
        return self::call();
    }


    /**
     * @param mixed $dir
     */
    public static function setDir($dir)
    {
        self::call();
    }

    /**
     * @return mixed
     */
    public static function getView()
    {
        return self::call();
    }


    /**
     * @param mixed $view
     */
    public static function setView($view)
    {
        self::call();
    }

    /**
     * @return mixed
     */
    public static function getFileExt()
    {
        return self::call();
    }


    /**
     * @param mixed $fileExt
     */
    public static function setFileExt($fileExt)
    {
        self::call();
    }

    /**
     * @return mixed
     */
    public static function getBase()
    {
        return self::call();
    }


    /**
     * @param mixed $base
     */
    public static function setBase($base)
    {
        self::call();
    }

    /**
     * @return mixed
     */
    public static function getTheme()
    {
        return self::call();
    }


    /**
     * @param mixed $theme
     */
    public static function setTheme($theme)
    {
        self::call();
    }

    /**
     * @return mixed
     */
    public static function getLayout()
    {
        return self::call();
    }

    /**
     * @param mixed $layout
     */
    public static function setLayout($layout)
    {
        self::call();
    }

    /**
     * @return array
     */
    public static function getSharedData()
    {
        return self::call();
    }


    /**
     * @param $key
     * @param $value
     */
    public static function share($key, $value)
    {
        self::call();
    }


    /**
     * @param $key
     *
     * @return mixed
     */
    public static function shared($key)
    {
        return self::call();
    }


    /**
     * @param array $data
     */
    public static function setData(array $data)
    {
        self::call();
    }

    /**
     * @return array
     */
    public static function getData()
    {
        return self::call();
    }


    /**
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        self::call();
    }


    /**
     * @param $key
     *
     * @return mixed
     */
    public static function get($key)
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getPath()
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getViewPath()
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getLayoutPath()
    {
        return self::call();
    }

    /**
     * @return bool
     */
    public static function isAjax()
    {
        return self::call();
    }


    /**
     * @param       $viewPath
     * @param array $data
     * @param bool  $bypass
     *
     * @return string
     */
    public static function render($viewPath, array $data = null, $bypass = false)
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function view()
    {
        return self::call();
    }


    /**
     * @param            $viewPath
     * @param array|null $data
     *
     * @return string
     * @throws ViewNotFoundException
     */
    public static function renderView($viewPath, array $data = null)
    {
        return self::call();
    }


    /**
     * @param array|null $data
     *
     * @return string
     */
    public static function renderLayout(array $data = null)
    {
        return self::call();
    }
}