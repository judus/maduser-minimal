<?php namespace Maduser\Minimal\Base\Middlewares;

use Maduser\Minimal\Base\Middlewares\Middleware;

class ReportAccess extends Middleware
{
    public function before()
    {
        return false;
    }
}