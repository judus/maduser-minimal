<?php namespace Maduser\Minimal\Base\Interfaces;

/**
 * Interface AssetsInterface
 *
 * @package Maduser\Minimal\Base\Interfaces
 */
interface AssetsInterface
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
     * @param      $urls
     * @param null $key
     *
     * @return
     */
	public function addCss($urls, $key = null);

    /**
     * @param      $urls
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