<?php namespace Maduser\Minimal\Base\Interfaces;

/**
 * Interface ConfigInterface
 *
 * @package Maduser\Minimal\Base\Interfaces
 */
interface ConfigInterface
{
    /**
     * @param      $name
     * @param null $value
     *
     * @return mixed
     */
	function item($name, $value = null);
}