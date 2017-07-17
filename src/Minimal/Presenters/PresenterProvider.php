<?php namespace Maduser\Minimal\Providers;

use Maduser\Minimal\Core\Presenter;

class PresenterProvider extends Provider
{
    public function resolve()
    {
        return new Presenter();
    }
}