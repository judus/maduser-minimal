<?php namespace Maduser\Minimal\Base\Core;

/**
 * Class Middleware
 *
 * @package Maduser\Minimal\Base\Core
 */
class Middleware
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
     *
     * @return mixed
     */
    public function dispatch(\Closure $task)
    {
        $beforeResponse = $this->before($this->getMiddlewares());

        if ($beforeResponse === false || $beforeResponse !== true) {
            return $beforeResponse;
        }

        $response = $task();

        $afterResponse = $this->after($this->getMiddlewares());

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
    public function before(array $middlewares)
    {
        return $this->execute('before', $middlewares);
    }

    /**
     * @param array $middlewares
     *
     * @return bool
     */
    public function after(array $middlewares)
    {
        return $this->execute('after', $middlewares);
    }

    protected function execute($when, $middlewares)
    {
        foreach ($middlewares as $key => $middleware) {

            $parameters = [];

            if (is_array($middleware)) {
                $parameters = $middleware;
                $middleware = $key;
            }

            if (class_exists($middleware)) {

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