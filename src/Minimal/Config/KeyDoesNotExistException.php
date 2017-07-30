<?php namespace Maduser\Minimal\Config;

use Maduser\Minimal\Exceptions\MinimalException;

/**
 * Class KeyDoesNotExistException
 *
 * @package Maduser\Minimal\Config
 */
class KeyDoesNotExistException extends MinimalException
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

        return debug_backtrace()[6]['file'];
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

        return debug_backtrace()[6]['line'];
    }
}