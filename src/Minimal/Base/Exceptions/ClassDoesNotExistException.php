<?php namespace Maduser\Minimal\Base\Exceptions;

/**
 * Class ClassDoesNotExistException
 *
 * @package Maduser\Minimal\Base\ClassDoesNotExistException
 */
class ClassDoesNotExistException extends MinimalException
{
    /**
     * @return mixed
     */
    public function getMyFile()
    {
        if ($this->isMessageObject()) {
            return $this->myMessage->getFile();
        }

        return debug_backtrace()[4]['file'];
    }

    /**
     * @return mixed
     */
    public function getMyLine()
    {
        if ($this->isMessageObject()) {
            return $this->myMessage->getLine();
        }

        return debug_backtrace()[4]['line'];
    }
}