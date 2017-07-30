<?php namespace Maduser\Minimal\Routers;

use Maduser\Minimal\Exceptions\MinimalException;

/**
 * Class RouteNotFoundException
 *
 * @package Maduser\Minimal\Routers
 */
class RouteNotFoundException extends MinimalException
{
    /**
     * @return mixed
     */
    public function getMyFile()
    {
        if ($this->isMessageObject()) {
            /** @noinspection PhpUndefinedMethodInspection */
            return $this->myMessage->getFile();
        }

        return debug_backtrace()[2]['file'];
    }

    /**
     * @return mixed
     */
    public function getMyLine()
    {
        if ($this->isMessageObject()) {
            /** @noinspection PhpUndefinedMethodInspection */
            return $this->myMessage->getLine();
        }

        return debug_backtrace()[2]['line'];
    }
}