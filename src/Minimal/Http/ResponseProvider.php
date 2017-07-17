<?php namespace Maduser\Minimal\Http;

use Maduser\Minimal\Providers\Provider;

class ResponseProvider extends Provider
{
    public function resolve()
    {
        return new Response();
    }
}