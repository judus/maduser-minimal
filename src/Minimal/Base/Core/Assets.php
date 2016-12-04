<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Interfaces\AssetsInterface;

/**
 * Class Asset
 *
 * @package Maduser\Minimal\Base\Core
 */
class Assets implements AssetsInterface
{
    /**
     * @var string
     */
    private $base = '';

    /**
     * @var string
     */
    private $theme = '';

    /**
     * @var string
     */
    private $cssDir = 'css';

    /**
     * @var string
     */
    private $jsDir = 'js';

    /**
     * @var string
     */
    private $defaultKey = 'default';

    /**
     * @var array
     */
    private $cssFiles = [];

    /**
     * @var array
     */
    private $jsFiles = [];

    /**
     * @var array
     */
    private $inlineScripts = [];

    /**
     * @var array
     */
    private $externalCss = [];

    /**
     * @var array
     */
    private $externalJs = [];

    /**
     * @param $path
     */
    public function setBase($path)
    {
        $this->base = $path;
    }

    /**
     * @return string
     */
    public function getBase()
    {
        $base = rtrim($this->base, '/') . '/';
        $base = '/' . ltrim($base, '/');
        return $base;
    }

    /**
     * @param $path
     */
    public function setTheme($path)
    {
        $this->theme = $path;
    }

    /**
     * @return string
     */
    public function getTheme()
    {
        return rtrim($this->theme, '/') . '/';
    }

    /**
     * @param $path
     */
    public function setCssDir($path)
    {
        $this->cssDir = $path;
    }

    /**
     * @return string
     */
    public function getCssDir()
    {
        return rtrim($this->cssDir, '/') . '/';
    }

    /**
     * @param $path
     */
    public function setJsDir($path)
    {
        $this->jsDir = $path;
    }

    /**
     * @return string
     */
    public function getJsDir()
    {
        return rtrim($this->jsDir, '/') . '/';
    }

    /**
     * @return string
     */
    public function getDefaultKey()
    {
        return $this->defaultKey;
    }

    /**
     * @param $defaultKey
     */
    public function setDefaultKey($defaultKey)
    {
        $this->defaultKey = $defaultKey;
    }

    /**
     * @return array
     */
    public function getCssFiles()
    {
        return $this->cssFiles;
    }

    /**
     * @return array
     */
    public function getJsFiles()
    {
        return $this->jsFiles;
    }

    /**
     * @return string
     */
    public function getJsPath()
    {
        return $this->getBase() . $this->getTheme() . $this->getJsDir();
    }

    /**
     * @param null $key
     *
     * @return null|string
     */
    public function key($key = null)
    {
        return $key ? $key : $this->getDefaultKey();
    }

    /**
     * Asset constructor.
     */
    public function __construct()
    {
        $this->cssFiles[$this->key()] = [];
        $this->jsFiles[$this->key()] = [];
        $this->externalJs[$this->key()] = [];
        $this->inlineScripts[$this->key()] = [];
    }

    /**
     * @param      $urls
     * @param null $key
     */
    public function addCss($urls, $key = null)
    {
        if (is_array($urls)) {
            foreach ($urls as $url) {
                $this->addCss($url, $key);
            }
        }

        if (is_string($urls)) {
            $this->cssFiles[$this->key($key)][] =
                $this->getBase() . $this->getTheme() . $this->getCssDir() . $urls;
        }
    }

    /**
     * @param      $urls
     * @param null $key
     */
    public function addJs($urls, $key = null)
    {
        if (is_array($urls)) {
            foreach ($urls as $url) {
                $this->addJs($url, $key);
            }
        }

        if (is_string($urls)) {
            $this->jsFiles[$this->key($key)][] =
                $this->getBase() . $this->getTheme() . $this->getJsDir() . $urls;
        }
    }

    /**
     * @param null $key
     *
     * @return string
     */
    public function getCss($key = null)
    {
        $cssFiles = $this->cssFiles[$this->key($key)];
        $html = '';
        foreach ($cssFiles as $cssFile) {
            $html = empty($html) ? $html : $html . "\t";
            $html .= '<link rel="stylesheet" href="' . $cssFile . '">' . "\n";
        }

        return $html;
    }

    /**
     * @param null $key
     *
     * @return string
     */
    public function getJs($key = null)
    {
        $jsFiles = $this->jsFiles[$this->key($key)];
        $html = '';
        foreach ($jsFiles as $jsFile) {
            $html = empty($html) ? $html : $html . "\t";
            $html .= '<script src="' . $jsFile . '" ></script>' . "\n";

        }

        return $html;
    }

    /**
     * @param      $urls
     * @param null $key
     */
    public function addExternalCss($urls, $key = null)
    {
        if (is_array($urls)) {
            foreach ($urls as $url) {
                $this->addExternalCss($url, $key);
            }
        }

        if (is_string($urls)) {
            $this->externalCss[$this->key($key)][] = $urls;
        }
    }

    /**
     * @param null $key
     *
     * @return string
     */
    public function getExternalCss($key = null)
    {
        $externalCss = $this->externalCss[$this->key($key)];
        $html = '';
        foreach ($externalCss as $cssFile) {
            $html = empty($html) ? $html : $html . "\t";
            $html .= '<link rel="stylesheet" href="' . $cssFile . '">' . "\n";

        }

        return $html;
    }

    /**
     * @param      $urls
     * @param null $key
     */
    public function addExternalJs($urls, $key = null)
    {
        if (is_array($urls)) {
            foreach ($urls as $url) {
                $this->addExternalJs($url, $key);
            }
        }

        if (is_string($urls)) {
            $this->externalJs[$this->key($key)][] = $urls;
        }
    }

    /**
     * @param null $key
     *
     * @return string
     */
    public function getExternalJs($key = null)
    {
        $externalJs = $this->externalJs[$this->key($key)];
        $html = '';
        foreach ($externalJs as $jsFile) {
            $html = empty($html) ? $html : $html . "\t";
            $html .= '<script src="' . $jsFile . '" ></script>' . "\n";

        }

        return $html;
    }

    /**
     * @param          $key
     * @param \Closure $inlineScript
     */
    public function addInlineScripts($key, \Closure $inlineScript)
    {
        $this->inlineScripts[$this->key($key)][] = $inlineScript();
    }

    /**
     * @param null $key
     *
     * @return string
     */
    public function getInlineScripts($key = null)
    {
        $inlineScripts = $this->inlineScripts[$this->key($key)];
        $html = '';
        foreach ($inlineScripts as $inlineScript) {
            $html = empty($html) ? $html : $html . "\t";
            $html .= $inlineScript . "\n";

        }

        return $html;
    }

}