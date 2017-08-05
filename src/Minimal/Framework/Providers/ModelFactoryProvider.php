<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Controllers\Factories\ModelFactory;

/**
 * Class ModelFactoryProvider
 *
 * @package Maduser\Minimal\Providers
 */
class ModelFactoryProvider extends AbstractProvider
{
    /**
     * @return ModelFactory
     */
    public function resolve()
    {
        return new ModelFactory();
    }
}