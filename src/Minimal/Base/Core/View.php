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
		include $this->getPath() . $viewPath;
		$rendered = ob_get_contents();
		ob_end_clean();
		return $rendered;
	}
}