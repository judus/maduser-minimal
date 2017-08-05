<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Controllers\Factories\ViewFactory;

/**
 * Class ViewFactoryProvider
 *
 * @package Maduser\Minimal\Providers
 */
class ViewFactoryProvider extends AbstractProvider
{
    /**
     * @return ViewFactory
     */
    public function resolve()
    {
        return new ViewFactory();
    }
}