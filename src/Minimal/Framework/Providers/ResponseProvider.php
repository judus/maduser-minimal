<?php namespace Maduser\Minimal\Framework\Providers;

use Maduser\Minimal\Http\Response;

/**
 * Class ResponseProvider
 *
 * @package Maduser\Minimal\Providers
 */
class ResponseProvider extends AbstractProvider
{
    /**
     * @return Response
     */
    public function resolve()
    {
        return new Response();
    }
}