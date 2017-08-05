<?php namespace Maduser\Minimal\Config;

use Maduser\Minimal\Config\Contracts\ConfigInterface;
use Maduser\Minimal\Config\Exceptions\KeyDoesNotExistException;

/**
 * Class Config
 *
 * @package Maduser\Minimal\Config
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
     * @return ConfigInterface
     */
    public function setItems(array $items): ConfigInterface
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
     * @return ConfigInterface
     */
    public function setLiteral(bool $literal): ConfigInterface
    {
        $this->literal = $literal;

        return $this;
    }

    /**
     * @param      $name
     * @param null $else
     * @param bool $literal
     *
     * @return mixed|null
     */
    public function exists($name, $else = null, $literal = false)
    {
        $literal || $else = $this->find($name, $this->items);

        return isset($this->items[$name]) ?
            $this->items[$name] : $else;
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
        $literal = is_null($literal) ? $this->isLiteral() : $literal;

        func_num_args() < 2 || $this->items[$name] = $value;

        if (!$literal) {
            return $this->find($name, $this->items);
        }

        isset($this->items[$name]) || $this->throwKeyDoesNotExist($name);

        return $this->items[$name];
    }

    /**
     * @param           $name
     * @param null      $value
     * @param null|bool $literal
     *
     * @return mixed
     * @throws KeyDoesNotExistException
     */
    public function merge($name, $value = null, $literal = null)
    {
        $literal = is_null($literal) ? $this->isLiteral() : $literal;

        func_num_args() < 2 || $this->items[$name] = array_replace_recursive($this->items[$name], $value);

        if (!$literal) {
            return $this->find($name, $this->items);
        }

        isset($this->items[$name]) || $this->throwKeyDoesNotExist($name);

        return $this->items[$name];
    }

    /**
     * @param null|string $config
     * @param null|string $path
     */
    public function init(string $config = null, string $path = null)
    {
        is_array($config) && $this->setItems($config) ||
        $this->file(rtrim($path, '/') . '/' . ltrim($config, '/'));
    }

    /**
     * @param $file
     */
    public function file($file)
    {
        /** @noinspection PhpIncludeInspection */
        !is_file($file) || $this->setItems(
            array_merge_recursive($this->getItems(), require_once $file)
        );
    }

    /**
     * @param      $name
     * @param      $array
     * @param null $parent
     * @param bool $throw
     *
     * @return mixed
     */
    public function find($name, $array, $throw = false, $parent = null)
    {
        list($key, $child) = array_pad(explode('.', $name, 2), 2, null);

        if (!isset($array[$key]) && !$throw) {
            return null;
        }

        isset($array[$key]) || $this->throwKeyDoesNotExist($name);

        return $child ? $this->find($child, $array[$key], $name) : $array[$key];
    }

    /**
     * @param $name
     *
     * @throws KeyDoesNotExistException
     */
    public function throwKeyDoesNotExist($name)
    {
        throw new KeyDoesNotExistException(
            'Config key \'' . $name . '\' does not exist',
            ['Config' => $this->items]
        );
    }
}