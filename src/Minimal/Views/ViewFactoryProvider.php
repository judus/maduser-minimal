<?php namespace Maduser\Minimal\Views;

use Maduser\Minimal\Providers\Provider;

class ViewFactoryProvider extends Provider
{
    public function resolve()
    {
        return new ViewFactory();
    }
}