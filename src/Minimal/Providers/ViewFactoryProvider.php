<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Factories\ViewFactory;

class ViewFactoryProvider extends Provider
{
    public function resolve()
    {
        return new ViewFactory();
    }
}