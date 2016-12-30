<?php namespace Maduser\Minimal\Interfaces;

/**
 * Interface RequestInterface
 *
 * @package Maduser\Minimal\Interfaces
 */
interface RequestInterface
{
    /**
     * @return mixed
     */
    public function getRequestMethod();

    /**
     * @return mixed
     */
    public function getUriString();

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