<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Controllers\FrontController;
use Maduser\Minimal\Framework\Facades\IOC;

/**
 * Class FrontControllerProvider
 *
 * @package Maduser\Minimal\Providers
 */
class FrontControllerProvider extends AbstractProvider
{
    /**
     * @return FrontController
     */
    public function resolve()
    {
        return new FrontController(
            IOC::resolve('Router'),
            IOC::resolve('Response'),
            IOC::resolve('ModelFactory'),
            IOC::resolve('ViewFactory'),
            IOC::resolve('ControllerFactory')
        );
    }
}