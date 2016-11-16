<?php namespace Maduser\Minimal\Base\Interfaces;

/**
 * Interface RequestInterface
 *
 * @package Minimal\Base\Interfaces
 */
interface RequestInterface
{
	/**
	 * @return mixed
	 */
	public function fetchUriString();

	/**
	 * @return mixed
	 */
	public function explodeSegments();

	/**
	 * @return mixed
	 */
	public function getSegments();
}