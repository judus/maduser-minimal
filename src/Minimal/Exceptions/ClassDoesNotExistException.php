<?php namespace Maduser\Minimal\Exceptions;

/**
 * Class ClassDoesNotExistException
 *
 * @package Maduser\Minimal\ClassDoesNotExistException
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