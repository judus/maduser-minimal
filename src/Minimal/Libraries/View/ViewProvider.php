<?php namespace Maduser\Minimal\Libraries\View;

use Maduser\Minimal\Core\IOC;
use Maduser\Minimal\Providers\Provider;
use Maduser\Minimal\Libraries\View\View;

class ViewProvider extends Provider
{
    public function resolve()
    {
        return new View(
            IOC::resolve('Maduser\Minimal\Libraries\Assets\Assets')
        );
    }
}