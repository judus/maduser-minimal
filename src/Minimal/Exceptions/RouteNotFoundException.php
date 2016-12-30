<?php namespace Maduser\Minimal\Exceptions;

/**
 * Class RouteNotFoundException
 *
 * @package Maduser\Minimal\Exceptions
 */
class RouteNotFoundException extends MinimalException
{
    /**
     * @return mixed
     */
    public function getMyFile()
    {
        if ($this->isMessageObject()) {
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
            return $this->myMessage->getLine();
        }

        return debug_backtrace()[2]['line'];
    }
}