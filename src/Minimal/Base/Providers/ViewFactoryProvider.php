<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Factories\ViewFactory;

class ViewFactoryProvider extends Provider
{
    public function resolve()
    {
        return new ViewFactory();
    }
}