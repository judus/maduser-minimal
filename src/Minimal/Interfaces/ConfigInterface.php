<?php namespace Maduser\Minimal\Interfaces;

/**
 * Interface ConfigInterface
 *
 * @package Maduser\Minimal\Interfaces
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