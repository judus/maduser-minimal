<?php namespace Maduser\Minimal\Collections;

use Maduser\Minimal\Collections\InvalidKeyException;
use Maduser\Minimal\Collections\KeyInUseException;
use Maduser\Minimal\Collections\CollectionInterface;

/**
 * Class Collection
 *
 * @package Maduser\Minimal\Collections
 */
class Collection implements CollectionInterface, \Iterator
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

	public function hasItems()
    {
        return $this->count() > 0;
    }


	public function extract($key)
    {
        $extracted = [];

        foreach ($this->items as $item) {
            foreach (func_get_args() as $key) {
                if (is_object($item)) {
                    $extracted[] = $item->{$key};
                } else {
                    $extracted[] = $item[$key];
                }
            }
        }

        return $extracted;
    }

	/**
	 * @return array
	 */
	public function getArray()
	{
		return $this->items;
	}

    /**
     * Return the current element
     *
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * Move forward to next element
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        return next($this->items);
    }

    /**
     * Return the key of the current element
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return key($this->items);
    }

    /**
     * Checks if current position is valid
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->current() !== false;
    }

    /**
     * Rewind the Iterator to the first element
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        reset($this->items);
    }

    public function toArray()
    {
        $items = [];
        foreach ($this->items as $key => $item) {
            if ($item instanceof CollectionInterface) {
                $items[$key] = $item->toArray();
            } else {
                $items[$key] = $item->toArray();
            }
        }

        return $items;
    }

    public function __toString()
    {

        d($this->items);

        foreach ($this->items as $item) {
            d($item->toArray());
        }


        dd('end');

        /*
        $items = [];
        foreach ($this->items as $item) {
            if ($item instanceof \Maduser\Minimal\Collections\CollectionInterface) {
                $items[] = $item->getArray();
            } else {
                $items[] = $item;
            }
        }
        */
        return json_encode($this->items);
    }
}