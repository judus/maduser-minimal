<?php namespace Maduser\Minimal\Libraries\Content;

use Maduser\Minimal\Facades\IOC;
use Maduser\Minimal\Providers\Provider;

class ContentProvider extends Provider
{
    public function resolve()
    {
        return IOC::make('Maduser\Minimal\Libraries\Content\Content');
    }
}