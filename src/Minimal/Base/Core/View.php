<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Exceptions\MethodNotExistsException;
use Maduser\Minimal\Base\Interfaces\ViewInterface;
use Maduser\Minimal\Base\Interfaces\AssetInterface;

/**
 * Class View
 *
 * @package Maduser\Minimal\Base\Core
 */
class View implements ViewInterface
{
    /**
     * @var
     */
    private $presenter;

    /**
     * @var
     */
    private $asset;

    /**
     * @var
     */
    private $base;

    /**
     * @var
     */
    private $theme;

    /**
     * @var
     */
    private $dir;

    /**
     * @var
     */
    private $fileExt = '.php';

    /**
     * @var
     */
    private $view;

    /**
     * @var
     */
    private $layout;

    /**
     * @var array
     */
    private $sharedData = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * @return mixed
     */
    public function getAsset()
    {
        return $this->asset;
    }

    /**
     * @param mixed $asset
     */
    public function setAsset($asset)
    {
        $this->asset = $asset;
    }

    /**
     * @return mixed
     */
    public function getDir()
    {
        return rtrim($this->dir, '/') . '/';
    }

    /**
     * @param mixed $dir
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
    }

    /**
     * @return mixed
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param mixed $view
     */
    public function setView($view)
    {
        $this->view = $view;
    }

    /**
     * @return mixed
     */
    public function getFileExt()
    {
        return $this->fileExt;
    }

    /**
     * @param mixed $fileExt
     */
    public function setFileExt($fileExt)
    {
        $this->fileExt = $fileExt;
    }

    /**
	 * @return mixed
	 */
	public function getBase()
	{
		return $this->base;
	}

	/**
	 * @param mixed $base
	 */
	public function setBase($base)
	{
		$this->base = empty($base) ? '' : rtrim($base, '/') . '/';
	}

	/**
	 * @return mixed
	 */
	public function getTheme()
	{
		return $this->theme;
	}

	/**
	 * @param mixed $theme
	 */
	public function setTheme($theme)
	{
		$this->theme = empty($theme) ? '' : rtrim($theme, '/') . '/';
	}

    /**
     * @return mixed
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param mixed $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * @return array
     */
    public function getSharedData()
    {
        return $this->sharedData;
    }

    /**
     * @param $key
     * @param $value
     */
    public function share($key, $value)
    {
        $this->sharedData[$key] = $value;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function shared($key)
    {
        return $this->data[$key];
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = array_merge($this->data, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->data[$key];
    }

    /**
     * View constructor.
     *
     * @param Asset          $asset
     */
    public function __construct(Asset $asset = null)
    {
        $this->setAsset($asset);
    }

    /**
	 * @return string
	 */
	public function getPath()
	{
		return $this->getBase() . $this->getTheme() . $this->getDir();
	}

    /**
     * @return string
     */
    public function getViewPath()
    {
        return $this->getPath() . $this->getView() . $this->getFileExt();
    }

    /**
     * @return string
     */
    public function getLayoutPath()
    {
        return $this->getPath() . $this->getLayout() . $this->getFileExt();
    }


    /**
     * @return bool
     */
    public function isAjax()
    {
        if ( ! empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            return true;
        }
        return false;
    }

    /**
	 * @param       $viewPath
	 * @param array $data
	 *
	 * @return string
	 */
	public function render($viewPath, array $data = null, $bypass = false)
	{
	    $this->setView($viewPath);

        if (!is_null($data)) {
            $this->setData($data);
        }


        if (!$this->isAjax() && $this->getLayout() !== null && !$bypass) {
            return $this->renderLayout($this->getSharedData());
        }

        return $this->renderView($this->getView(), $this->getData());
	}

    /**
     * @return string
     */
    public function yield()
    {
        return $this->renderView($this->getView(), $this->getData());
	}

    /**
     * @param            $viewPath
     * @param array|null $data
     *
     * @return string
     */
    public function renderView($viewPath, array $data = null)
    {
        $this->setView($viewPath);

        !$data or extract($data);
        ob_start();

        /** @noinspection PhpIncludeInspection */
        include rtrim(
                $this->getViewPath(), $this->getFileExt()
            ) . $this->getFileExt();
        $rendered = ob_get_contents();
        ob_end_clean();

        return $rendered;
    }

    /**
     * @param array|null $data
     *
     * @return string
     */
    public function renderLayout(array $data = null)
    {
        !$data or extract($data);
        ob_start();

        /** @noinspection PhpIncludeInspection */
        include rtrim(
                $this->getLayoutPath(), $this->getFileExt()
            ) . $this->getFileExt();
        $rendered = ob_get_contents();
        ob_end_clean();

        return $rendered;
    }


}