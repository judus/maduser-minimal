<?php namespace Maduser\Minimal\Libraries\View;

use Maduser\Minimal\Core\IOC;
use Maduser\Minimal\Providers\Provider;
use Maduser\Minimal\Libraries\View\View;

class ViewProvider extends Provider
{
    public function resolve()
    {
        return new View();

        /**
         * This could be also possible, but I think it's not a good idea.
         * The View class should work without Assets or Content
         * Better do this in the controller:
         * $this->view->share('assets', $this->assets);
         * $this->view->share('contents', $this->contents);
         */
        /*
        return new View(
            IOC::resolve('Maduser\Minimal\Libraries\Assets\Assets'),
            IOC::resolve('Maduser\Minimal\Libraries\Content\Content')
        );
        */
    }
}