<?php namespace Maduser\Minimal\Models;

use Maduser\Minimal\Providers\Provider;

class ModelFactoryProvider extends Provider
{
    public function resolve()
    {
        return new ModelFactory();
    }
}