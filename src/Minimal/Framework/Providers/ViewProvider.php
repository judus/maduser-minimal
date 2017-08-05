<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Framework\Facades\IOC;
use Maduser\Minimal\Views\View;

/**
 * Class ViewProvider
 *
 * @package Maduser\Minimal\Providers
 */
class ViewProvider extends AbstractProvider
{
    /**
     * @return View
     */
    public function resolve()
    {
        return new View(
            IOC::resolve('Assets')
        );
    }
}