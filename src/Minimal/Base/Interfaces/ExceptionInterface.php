<?php namespace Maduser\Minimal\Base\Interfaces;

/**
 * Interface ExceptionInterface
 *
 * @package Maduser\Minimal\Base\Interfaces
 */
interface ExceptionInterface
{
	/**
	 * @return mixed
	 */
	public function getMessage();

	/**
	 * @return mixed
	 */
	public function getCode();

	/**
	 * @return mixed
	 */
	public function getFile();

	/**
	 * @return mixed
	 */
	public function getLine();

	/**
	 * @return mixed
	 */
	public function getTrace();

	/**
	 * @return mixed
	 */
	public function getTraceAsString();

	/**
	 * @return mixed
	 */
	public function __toString();

	/**
	 * ExceptionInterface constructor.
	 *
	 * @param null $message
	 * @param int  $code
	 */
	public function __construct($message = null, $code = 0);
}