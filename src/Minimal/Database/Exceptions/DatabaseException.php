<?php namespace Maduser\Minimal\Database\Exceptions;

use Maduser\Minimal\Exceptions\MinimalException;

/**
 * Class Exception
 *
 * @package Maduser\Minimal\Database\DatabaseException
 */
class DatabaseException extends MinimalException
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