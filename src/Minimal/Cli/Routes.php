<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Core\Collection;
use Maduser\Minimal\Core\Minimal;
use Maduser\Minimal\Core\Route;

class Routes
{
    /**
     * @var Minimal
     */
    private $minimal;


    public function __construct($minimal)
    {
        $this->console = new Console();

        /** @var Minimal minimal */
        $this->minimal = $minimal;

        $this->list();
    }

    protected function list()
    {
        $router = $this->minimal->getRouter();
        /** @var Collection $routes */
        $routes = $router->getRoutes();

        //var_dump();die();
        $routesAll = $routes->get('ALL');

        foreach ($routesAll->getArray() as $route) {
            /** @var Collection $collection */
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
                'action' => $route->isClosure() ? '<= Closure()' : $route->getController() . '@' . $route->getAction(),
                'middleware' => $str
            ];

        }

        $this->console->table(
            $array,
            [['Type', 'Pattern', 'Action', 'Middlewares']]
        );

    }



}