<?php namespace Maduser\Minimal\Collections;

use Maduser\Minimal\Exceptions\MinimalException;

/**
 * Class KeyInUseException
 *
 * @package Maduser\Minimal\Exceptions
 */
class KeyInUseException extends MinimalException
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

        return debug_backtrace()[3]['file'];
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

        return debug_backtrace()[3]['line'];
    }
}