<?php namespace Maduser\Minimal\Base\Interfaces;

/**
 * Interface AssetInterface
 *
 * @package Maduser\Minimal\Base\Interfaces
 */
interface AssetInterface
{
	/**
	 * @param $path
	 */
	public function setBaseDir($path);

	/**
	 * @return string
	 */
	public function getBaseDir();

	/**
	 * @param $url
	 */
	public function addCssFile($url);

	/**
	 * @param $url
	 */
	public function addJsFile($url);

	/**
	 * @return array
	 */
	public function getCssFiles();

	/**
	 * @return array
	 */
	public function getJsFiles();
}