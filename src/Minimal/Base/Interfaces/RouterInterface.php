<?php namespace Maduser\Minimal\Base\Interfaces;

/**
 * Interface RouterInterface
 *
 * @package Maduser\Minimal\Base\Interfaces
 */
interface RouterInterface
{
    /**
     * @param null $uriString
     *
     * @return RouteInterface
     */
    public function getRoute($uriString = null): RouteInterface;
}