<?php namespace Maduser\Minimal\Http;

use Maduser\Minimal\Providers\Provider;

class RequestProvider extends Provider
{
    public function resolve()
    {
        return new Request();
    }
}