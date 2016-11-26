<?php namespace Maduser\Minimal\Base\Exceptions;

/**
 * Class InvalidKeyException
 *
 * @package Maduser\Minimal\Base\Exceptions
 */
class InvalidKeyException extends MinimalException
{
    /**
     * @return mixed
     */
    public function getMyFile()
    {
        if ($this->isMessageObject()) {
            return $this->myMessage->getFile();
        }

        return debug_backtrace()[3]['file'];
    }

    /**
     * @return mixed
     */
    public function getMyLine()
    {
        if ($this->isMessageObject()) {
            return $this->myMessage->getLine();
        }

        return debug_backtrace()[3]['line'];
    }
}