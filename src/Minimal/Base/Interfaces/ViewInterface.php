<?php namespace Maduser\Minimal\Base\Interfaces;

/**
 * Interface ViewInterface
 *
 * @package Maduser\Minimal\Base\Interfaces
 */
interface ViewInterface
{
	/**
	 * @return mixed
	 */
	public function getBaseDir();

	/**
	 * @param mixed $baseDir
	 */
	public function setBaseDir($baseDir);

	/**
	 * @param       $viewPath
	 * @param array $data
	 *
	 * @return string
	 */
	public function render($viewPath, array $data = null);
}