<?php namespace Maduser\Minimal\Base\Factories;

use Maduser\Minimal\Base\Factories\MinimalFactory;
use Maduser\Minimal\Base\Interfaces\ViewFactoryInterface;
use Maduser\Minimal\Base\Interfaces\ViewInterface;

class ViewFactory extends MinimalFactory implements ViewFactoryInterface
{
    public function create($class, array $params = null) : ViewInterface
    {
        return parent::createInstance($class, $params);
    }
}