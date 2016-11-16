<?php namespace Maduser\Minimal\Base\Interfaces;

/**
 * Interface ResponseInterface
 *
 * @package Maduser\Minimal\Base\Interfaces
 */
interface ResponseInterface
{
	/**
	 * @return mixed
	 */
	public function getHeaders();

	/**
	 * @return mixed
	 */
	public function getContent();

	/**
	 * @return mixed
	 */
	public function send();

	/**
	 * @return mixed
	 */
	public function exit();

	/**
	 * @param $getResult
	 *
	 * @return mixed
	 */
	public function setContent($getResult);
}