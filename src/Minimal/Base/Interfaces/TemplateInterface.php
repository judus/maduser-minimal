<?php namespace Maduser\Minimal\Base\Interfaces;

/**
 * Interface Template
 *
 * @package Minimal\Base\Interfaces
 */
interface TemplateInterface
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