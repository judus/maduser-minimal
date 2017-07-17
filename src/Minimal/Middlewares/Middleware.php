<?php namespace Maduser\Minimal\Middlewares;

use Maduser\Minimal\Loaders\IOC;

/**
 * Class Middleware
 *
 * @package Maduser\Minimal\Core
 */
class Middleware implements MiddlewareInterface
{
    /**
     * @var array
     */
    private $middlewares = [];

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @param array $middlewares
     */
    public function setMiddlewares(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    /**
     * Middleware constructor.
     *
     * @param array $middlewares
     */
    public function __construct(array $middlewares)
    {
        $this->setMiddlewares($middlewares);
    }

    /**
     * @param \Closure $task
     * @param null     $middlewares
     *
     * @return mixed
     */
    public function dispatch(\Closure $task, $middlewares = null)
    {
        is_array($middlewares) || $middlewares = $this->getMiddlewares();

        $beforeResponse = $this->before($middlewares);

        if ($beforeResponse === false || $beforeResponse !== true) {
            return $beforeResponse;
        }

        $response = $task();

        $afterResponse = $this->after($middlewares, $response);

        if ($afterResponse === false || $afterResponse !== true) {
            return $afterResponse;
        }

        return $response;
    }

    /**
     * @param array $middlewares
     *
     * @return bool
     */
    public function before($middlewares = null)
    {
        return $this->execute('before', $middlewares);
    }

    /**
     * @param array $middlewares
     * @param       $response
     *
     * @return bool
     */
    public function after($middlewares = null, $response = null)
    {
        return $this->execute('after', $middlewares, $response);
    }

    protected function execute($when, $middlewares, $response = null)
    {
        foreach ($middlewares as $key => $middleware) {

            $parameters = [];

            if (is_array($middleware)) {
                $parameters = $middleware;
                $middleware = $key;
            }
            if (class_exists($middleware)) {
                if ($response) {
                    array_push($parameters, $response);
                }

                $middleware = IOC::make($middleware, $parameters);
                $response = $middleware->{$when}($this);

                if (!is_null($response) &&
                    ($response === false || $response !== true)
                ) {
                    return $response;
                }
            }
        }

        return true;
    }


}