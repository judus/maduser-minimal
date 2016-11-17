<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Interfaces\ViewInterface;

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
	private $baseDir;

	/**
	 * @var
	 */
	private $theme;

    /**
     * @var
     */
    private $viewDir;

    /**
     * @var
     */
    private $fileExt = '.php';

    /**
     * @var
     */
    private $view;

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
	public function getBaseDir()
	{
		return $this->baseDir;
	}

	/**
	 * @param mixed $baseDir
	 */
	public function setBaseDir($baseDir)
	{
		$this->baseDir = empty($baseDir) ? '' : rtrim($baseDir, '/') . '/';
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
	public function getViewDir()
	{
		return $this->viewDir;
	}

	/**
	 * @param mixed $viewDir
	 */
	public function setViewDir($viewDir)
	{
		$this->viewDir = empty($viewDir) ? '' : rtrim($viewDir, '/') . '/';
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->getBaseDir() . $this->getTheme() . $this->getViewDir();
	}

	public function getFullViewPath()
    {
        return $this->getPath() . $this->getView() . $this->getFileExt();
    }

	/**
	 * @param       $viewPath
	 * @param array $data
	 *
	 * @return string
	 */
	public function render($viewPath, array $data = null)
	{
		!$data or extract($data);
		ob_start();

        $this->setView($viewPath);
		include rtrim($this->getFullViewPath(),
                $this->getFileExt()) . $this->getFileExt();
		$rendered = ob_get_contents();
		ob_end_clean();
		return $rendered;
	}

}