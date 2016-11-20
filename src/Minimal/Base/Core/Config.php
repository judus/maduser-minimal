<?php namespace Maduser\Minimal\Base\Core;

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

		return $this->config[$name];
	}
}