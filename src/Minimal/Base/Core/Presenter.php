<?php
namespace Maduser\Minimal\Base\Core;

use Maduser\Minimal\Base\Interfaces\PresenterInterface;

class Presenter implements PresenterInterface
{
    public function sayHi()
    {
        return 'Hi from '.get_class($this).'!';
    }
}