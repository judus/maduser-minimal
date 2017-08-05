<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Http\Request;

/**
 * Class RequestProvider
 *
 * @package Maduser\Minimal\Providers
 */
class RequestProvider extends AbstractProvider
{
    /**
     * @return Request
     */
    public function resolve()
    {
        return new Request();
    }
}