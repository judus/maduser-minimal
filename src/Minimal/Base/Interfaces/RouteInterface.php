<?php namespace Maduser\Minimal\Base\Interfaces;

/**
 * Interface RouteInterface
 *
 * @package Maduser\Minimal\Base\Interfaces
 */
interface RouteInterface
{
	/**
	 * @param $uriPrefix
	 *
	 * @return mixed
	 */
	public function setUriPrefix($uriPrefix);

	/**
	 * @return mixed
	 */
	public function getUriPrefix();

	/**
	 * @param $cache
	 *
	 * @return mixed
	 */
	public function setCache($cache);

	/**
	 * @param $name
	 *
	 * @return mixed
	 */
	public function setModel($name);

	/**
	 * @return mixed
	 */
	public function getModel();

	/**
	 * @param $namespace
	 *
	 * @return mixed
	 */
	public function setNamespace($namespace);

	/**
	 * @param $name
	 *
	 * @return mixed
	 */
	public function setController($name);

	/**
	 * @return mixed
	 */
	public function getController();

	/**
	 * @param $name
	 *
	 * @return mixed
	 */
	public function setView($name);

	/**
	 * @return mixed
	 */
	public function getView();

	/**
	 * @param $name
	 *
	 * @return mixed
	 */
	public function setMethod($name);

	/**
	 * @return mixed
	 */
	public function getMethod();

	/**
	 * @param $name
	 *
	 * @return mixed
	 */
	public function setAction($name);

	/**
	 * @return mixed
	 */
	public function getAction();

	/**
	 * @param $name
	 *
	 * @return mixed
	 */
	public function setParams($name);

	/**
	 * @return mixed
	 */
	public function getParams();
}