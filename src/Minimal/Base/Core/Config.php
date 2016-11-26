<?php namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Exceptions\KeyDoesNotExistException;
use Maduser\Minimal\Base\Exceptions\KeyInUseException;
use Maduser\Minimal\Base\Exceptions\MinimalException;
use Maduser\Minimal\Base\Interfaces\ConfigInterface;

/**
 * Class Config
 *
 * @package Maduser\Minimal\Base\Core
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
	 */
	public function item($name, $value = NULL) {
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