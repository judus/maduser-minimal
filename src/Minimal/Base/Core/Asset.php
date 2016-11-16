<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Interfaces\AssetInterface;

/**
 * Class Asset
 *
 * @package Maduser\Minimal\Base\Core
 */
class Asset implements AssetInterface
{
	/**
	 * @var string
	 */
	private $baseDir = '';

	/**
	 * @var array
	 */
	private $cssFiles = [];

	/**
	 * @var array
	 */
	private $jsFiles = [];

	/**
	 * @param $path
	 */
	public function setBaseDir($path)
	{
		$this->baseDir = $path;
	}

	/**
	 * @return string
	 */
	public function getBaseDir()
	{
		return $this->baseDir;
	}

	/**
	 * @param $url
	 */
	public function addCssFile($url)
	{
		$this->cssFiles[] = $url;
	}

	/**
	 * @param $url
	 */
	public function addJsFile($url)
	{
		$this->jsFiles[] = $url;
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
}