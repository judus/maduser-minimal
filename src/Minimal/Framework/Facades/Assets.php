<?php namespace Maduser\Minimal\Framework\Facades;

use Maduser\Minimal\Assets\Assets as Implementation;

class Assets
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

    public static function setSource(
        /** @noinspection PhpUnusedParameterInspection */
        $path)
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getSource()
    {
        return self::call();
    }

    public static function setBase(
        /** @noinspection PhpUnusedParameterInspection */
        $path)
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getBase()
    {
        return self::call();
    }

    public static function setTheme(
        /** @noinspection PhpUnusedParameterInspection */
        $path)
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getTheme()
    {
        return self::call();
    }

    public static function setCssDir(
        /** @noinspection PhpUnusedParameterInspection */
        $path)
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getCssDir()
    {
        return self::call();
    }


    /**
     * @param $path
     *
     * @return mixed
     */
    public static function setJsDir($path)
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getJsDir()
    {
        return self::call();
    }

    /**
     * @param $path
     *
     * @return mixed
     */
    public static function setVendorDir($path)
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getVendorDir()
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getDefaultKey()
    {
        return self::call();
    }

    /**
     * @param $defaultKey
     *
     * @return mixed
     */
    public static function setDefaultKey($defaultKey)
    {
        return self::call();
    }

    /**
     * @return array
     */
    public static function getCssFiles()
    {
        return self::call();
    }

    /**
     * @return array
     */
    public static function getJsFiles()
    {
        return self::call();
    }

    /**
     * @return array
     */
    public static function getVendorFiles()
    {
        return self::call();
    }

    /**
     * @return string
     */
    public static function getJsPath()
    {
        return self::call();
    }

    /**
     * @param null $key
     *
     * @return null|string
     */
    public static function key($key = null)
    {
        return self::call();
    }

    /**
     * @param       $urls
     * @param null  $key
     * @param array $attr
     *
     * @return mixed
     */
    public static function addCss($urls, $key = null, array $attr = null)
    {
        return self::call();
    }

    /**
     * @param            $urls
     * @param null       $key
     * @param array|null $attr
     *
     * @return mixed
     */
    public static function addJs($urls, $key = null, array $attr = null)
    {
        return self::call();
    }

    /**
     * @param $url
     * @param $key
     *
     * @return mixed
     */
    public static function isRegisteredJsFile($url, $key)
    {
        return self::call();
    }

    /**
     * @param            $urls
     * @param null       $key
     * @param array|null $attr
     *
     * @return mixed
     */
    public static function addVendorCss($urls, $key = null, array $attr = null)
    {
        return self::call();
    }

    /**
     * @param            $urls
     * @param null       $key
     * @param array|null $attr
     *
     * @return mixed
     */
    public static function addVendorJs($urls, $key = null, array $attr = null)
    {
        return self::call();
    }

    /**
     * @param null $key
     *
     * @param null $concatFilename
     *
     * @return string
     */
    public static function getCss($key = null, $concatFilename = null)
    {
        return self::call();
    }

    /**
     * @param null $key
     *
     * @param null $concatFilename
     *
     * @return string
     */
    public static function getVendorCss($key = null, $concatFilename = null)
    {
        return self::call();
    }

    /**
     * @param null $key
     *
     * @param null $concatFilename
     *
     * @return string
     */
    public static function getJs($key = null, $concatFilename = null)
    {
        return self::call();
    }

    /**
     * @param null $key
     *
     * @param null $concatFilename
     *
     * @return string
     */
    public static function getVendorJs($key = null, $concatFilename = null)
    {
        return self::call();
    }

    /**
     * @param            $urls
     * @param null       $key
     * @param array|null $attr
     *
     * @return mixed
     */
    public static function addExternalCss($urls, $key = null, array $attr = null)
    {
        return self::call();
    }

    /**
     * @param null $key
     *
     * @return string
     */
    public static function getExternalCss($key = null)
    {
        return self::call();
    }

    /**
     * @param            $urls
     * @param null       $key
     * @param array|null $attr
     *
     * @return mixed
     */
    public static function addExternalJs($urls, $key = null, array $attr = null)
    {
        return self::call();
    }

    /**
     * @param null $key
     *
     * @return string
     */
    public static function getExternalJs($key = null)
    {
        return self::call();
    }

    /**
     * @param          $key
     * @param \Closure $inlineScript
     *
     * @return mixed
     */
    public static function addInlineScripts($key, \Closure $inlineScript)
    {
        return self::call();
    }

    /**
     * @param null $key
     *
     * @return string
     */
    public static function getInlineScripts($key = null)
    {
        return self::call();
    }

    /**
     * @param array $cssFiles
     *
     * @return mixed
     */
    public static function getCssTags(array $cssFiles)
    {
        return self::call();
    }

    /**
     * @param array $jsFiles
     *
     * @return mixed
     */
    public static function getJsTags(array $jsFiles)
    {
        return self::call();
    }
}