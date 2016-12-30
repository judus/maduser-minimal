<?php namespace Maduser\Minimal\Interfaces;

/**
 * Interface CollectionInterface
 *
 * @package Maduser\Minimal\Interfaces
 */
/**
 * Interface CollectionInterface
 *
 * @package Maduser\Minimal\Interfaces
 */
interface CollectionInterface
{
    /**
     * @param      $obj
     * @param null $key
     *
     * @return CollectionInterface
     */
    public function add($obj, $key = null): CollectionInterface;

	/**
	 * @param $key
	 */
	public function delete($key);

	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public function get($key);

	/**
	 * @param null $key
	 *
	 * @return int
	 */
	public function count($key = null);

	/**
	 * @return array
	 */
	public function getArray();
}