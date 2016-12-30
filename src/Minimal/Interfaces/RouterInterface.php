<?php namespace Maduser\Minimal\Interfaces;
/**
 * Interface RouterInterface
 *
 * @package Maduser\Minimal\Interfaces
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