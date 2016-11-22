<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\Response;

class ResponseProvider extends Provider
{
    public function resolve()
    {
        return new Response();
    }
}