<?php namespace Maduser\Minimal\Collections;

use Maduser\Minimal\Collections\InvalidKeyException;
use Maduser\Minimal\Collections\KeyInUseException;
use Maduser\Minimal\Collections\CollectionInterface;

/**
 * Class Collection
 *
 * @package Maduser\Minimal\Collections
 */
class Collection implements CollectionInterface
{
	/**
	 * @var array
	 */
	private $items = array();

    /**
     * @param      $obj
     * @param null $key
     *
     * @return \Maduser\Minimal\Collections\CollectionInterface
     * @throws \Maduser\Minimal\Collections\InvalidKeyException
     * @throws \Maduser\Minimal\Collections\KeyInUseException
     */
	public function add($obj, $key = null): CollectionInterface
	{
		if ($key == null) {
			$this->items[] = $obj;
		} else {
			if (isset($this->items[$key])) {
				throw new KeyInUseException("Collection key '".$key."' is already in use.", $this);
			} else {
			    if (!is_string($key) || is_int($key)) {
			        ! is_object($key) || $key = '(instance of) ' . get_class($key);
                    throw new InvalidKeyException("Collection key '" . $key . "' is not a valid key name.");
                }
				$this->items[$key] = $obj;
			}
		}

		return $this;
	}

    /**
     * @param $key
     *
     * @throws InvalidKeyException
     */
	public function delete($key)
	{
		if (isset($this->items[$key])) {
			unset($this->items[$key]);
		} else {
			throw new InvalidKeyException("Collection key '".$key."' does not exist.", $this);
		}
	}

    /**
     * @param $key
     *
     * @return mixed
     * @throws InvalidKeyException
     */
	public function get($key)
	{
		if (isset($this->items[$key])) {
			return $this->items[$key];
		} else {
			throw new InvalidKeyException("Collection key '" . $key . "' does not exist.",
                $this);
		}
	}

	/**
	 * @param null $key
	 *
	 * @return int
	 */
	public function count($key = null)
	{
		if (!is_null($key) && isset($this->items[$key])) {
			return count($this->items[$key]);
		} else {
			return count($this->items);
		}
	}

	/**
	 * @return array
	 */
	public function getArray()
	{
		return $this->items;
	}

}