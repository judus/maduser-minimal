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
	public function getContent();

    /**
     * @param $string
     *
     * @return mixed
     */
    public function header($string);

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