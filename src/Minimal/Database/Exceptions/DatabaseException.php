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
            /** @noinspection PhpUndefinedMethodInspection */
            return $this->myMessage->getFile();
        }

        $t = debug_backtrace();

        $item = $t[0];
        $item = isset($t[1]) && isset($t[1]['file']) ? $t[1] : $item;
        $item = isset($t[2]) && isset($t[2]['file']) ? $t[2] : $item;
        $item = isset($t[3]) && isset($t[3]['file']) ? $t[3] : $item;

        return $item['file'];
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

        $t = debug_backtrace();

        $item = $t[0];
        $item = isset($t[1]) && isset($t[1]['file']) ? $t[1] : $item;
        $item = isset($t[2]) && isset($t[2]['file']) ? $t[2] : $item;
        $item = isset($t[3]) && isset($t[3]['file']) ? $t[3] : $item;

        return $item['line'];
    }
}