<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Collections\Collection;
use Maduser\Minimal\Apps\Minimal;
use Maduser\Minimal\Routers\Route;

class Routes
{
    /**
     * @var Minimal
     */
    private $minimal;


    public function __construct(Minimal $minimal)
    {
        $this->console = new Console();

        /** @var Minimal minimal */
        $this->minimal = $minimal;

        $this->all();
    }

    protected function all()
    {
        $router = $this->minimal->getRouter();

        /** @var Collection $routes */
        $routes = $router->getRoutes();

        $routesAll = $routes->get('ALL');

        $array = [];

        foreach ($routesAll->getArray() as $route) {

            /** @var Route $route */

            $mws = $route->getMiddlewares();
            $str = '';
            foreach ($mws as $key => $mw) {

                $mw = is_array($mw) ? $key .'(' . implode($mw, ', ') .')' : $mw;
                $str .= !empty($str) ? ', ' . $mw : $mw;
            }

            $array[] = [
                'type' => $route->getRequestMethod(),
                'pattern' => '/' . ltrim($route->getUriPrefix() . $route->getUriPattern(), '/'),
                'action' => $route->hasClosure() ? '<= Closure()' : $route->getController() . '@' . $route->getAction(),
                'middleware' => $str
            ];

        }

        $this->console->table(
            $array,
            [['Type', 'Pattern', 'Action', 'Middlewares']]
        );

    }



}