<?php namespace Maduser\Minimal\Core;

use Maduser\Minimal\Exceptions\KeyDoesNotExistException;
use Maduser\Minimal\Interfaces\ConfigInterface;

/**
 * Class Config
 *
 * @package Maduser\Minimal\Core
 */
class Config implements ConfigInterface
{
	/**
	 * @var array
	 */
	protected $items = [];

    /**
     * @var bool
     */
    protected $literal = false;

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     *
     * @return Config
     */
    public function setItems(array $items): Config
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLiteral(): bool
    {
        return $this->literal;
    }

    /**
     * @param bool $literal
     *
     * @return Config
     */
    public function setLiteral(bool $literal): Config
    {
        $this->literal = $literal;

        return $this;
    }

    /**
     * @param           $name
     * @param null      $value
     * @param null|bool $literal
     *
     * @return mixed
     * @throws KeyDoesNotExistException
     */
    public function item($name, $value = null, $literal = null)
    {
        $literal = !is_null($literal) ? $literal : $this->isLiteral();

        if (func_num_args() > 1) {
            $this->items[$name] = $value;
        }

        if (!$literal) {
            return $this->find($name, $this->items);
        }

        isset($this->items[$name]) || $this->throwKeyDoesNotExist($name);

        return $this->items[$name];
    }

    /**
     * @param      $name
     * @param      $array
     * @param null $parent
     *
     * @return mixed
     */
    protected function find($name, $array, $parent = null)
    {
        list($key, $child) = array_pad(explode('.', $name, 2), 2, null);
        isset($array[$key]) || $this->throwKeyDoesNotExist($name);
        return $child ? $this->find($child, $array[$key], $name) : $array[$key];
    }

    /**
     * @param $name
     *
     * @throws KeyDoesNotExistException
     */
    protected function throwKeyDoesNotExist($name)
    {
        throw new KeyDoesNotExistException(
            'Config key \'' . $name . '\' does not exist',
            ['Config' => $this->items]
        );
    }
}