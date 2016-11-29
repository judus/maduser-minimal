<?php namespace Maduser\Minimal\Base\Providers;

use Maduser\Minimal\Base\Core\Presenter;

class PresenterProvider extends Provider
{
    public function resolve()
    {
        return new Presenter();
    }
}