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
	public function setBase($path);

	/**
	 * @return string
	 */
	public function getBase();

    /**
     * @param      $url
     * @param null $key
     *
     * @return
     */
	public function addCss($urls, $key = null);

    /**
     * @param      $url
     * @param null $key
     *
     * @return
     */
	public function addJs($urls, $key = null);

	/**
	 * @return array
	 */
	public function getCssFiles();

	/**
	 * @return array
	 */
	public function getJsFiles();
}