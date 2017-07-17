<?php namespace Maduser\Minimal\Views;

use Maduser\Minimal\Loaders\IOC;
use Maduser\Minimal\Providers\Provider;

class ViewProvider extends Provider
{
    public function resolve()
    {
        return new View(
            IOC::resolve('Maduser\Minimal\Assets\Assets')
        );
    }
}