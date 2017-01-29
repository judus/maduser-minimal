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
	protected $config = [];

    /**
     * @param      $name
     * @param null $value
     *
     * @return mixed
     * @throws KeyDoesNotExistException
     */
    public function item($name, $value = NULL)
    {
	    if (func_num_args() > 1) {
            $this->config[$name] = $value;
        }

        if (!isset($this->config[$name])) {
            throw new KeyDoesNotExistException(
                'Config key \''.$name.'\' does not exist',
                ['Config' => $this->config]
            );
        }

		return $this->config[$name];
	}
}