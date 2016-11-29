<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\IOC;
use Maduser\Minimal\Base\Core\View;

class ViewProvider extends Provider
{
    public function resolve()
    {
        return new View(
            IOC::resolve('Presenter')
        );
    }
}