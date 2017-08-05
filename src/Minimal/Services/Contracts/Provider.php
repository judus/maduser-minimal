<?php namespace Maduser\Minimal\Services\Contracts;

/**
 * Interface Provider
 *
 * @package Maduser\Minimal\Services\Contracts
 */
interface Provider
{
    /**
     * @param null $params
     *
     * @return mixed
     */
    public function resolve($params = null);
}