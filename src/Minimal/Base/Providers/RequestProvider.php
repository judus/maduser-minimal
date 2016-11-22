<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\Request;

class RequestProvider extends Provider
{
    public function resolve()
    {
        return new Request();
    }
}