<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Exceptions\KeyInUseException;
use Maduser\Minimal\Base\Interfaces\CollectionInterface;

/**
 * Class Collection
 *
 * @package Maduser\Minimal\Base\Core
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
	 * @return $this
	 * @throws KeyInUseException
	 */
	public function add($obj, $key = null)
	{
		if ($key == null) {
			$this->items[] = $obj;
		} else {
			if (isset($this->items[$key])) {
				throw new KeyInUseException("Key $key already in use.");
			} else {
				$this->items[$key] = $obj;
			}
		}

		return $this;
	}

	/**
	 * @param $key
	 */
	public function delete($key)
	{
		if (isset($this->items[$key])) {
			unset($this->items[$key]);
		} else {
			throw new InvalidKeyException("Invalid key $key.");
		}
	}

	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public function get($key)
	{
		if (isset($this->items[$key])) {
			return $this->items[$key];
		} else {
			throw new InvalidKeyException("Invalid key $key.");
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