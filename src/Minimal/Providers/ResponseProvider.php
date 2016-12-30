<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Core\Response;

class ResponseProvider extends Provider
{
    public function resolve()
    {
        return new Response();
    }
}