<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Core\Request;

class RequestProvider extends Provider
{
    public function resolve()
    {
        return new Request();
    }
}