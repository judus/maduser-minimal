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
            /** @noinspection PhpUndefinedMethodInspection */
            return $this->getMyMessage()->getFile();
        }

        return debug_backtrace()[4]['file'];
    }

    /**
     * @return mixed
     */
    public function getMyLine()
    {
        if ($this->isMessageObject()) {
            /** @noinspection PhpUndefinedMethodInspection */
            return $this->getMyMessage()->getLine();
        }

        return debug_backtrace()[4]['line'];
    }
}