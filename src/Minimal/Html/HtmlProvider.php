<?php

namespace Maduser\Minimal\Html;

use Collective\Html\HtmlBuilder;

use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\UrlGenerator;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\View\FileViewFinder;
use Maduser\Minimal\Loaders\IOC;


class HtmlProvider
{

    public function resolve()
    {
        $routeCollection = new RouteCollection();
        $request = new Request();
        $url = new UrlGenerator($routeCollection, $request);

        $engineResolver = new EngineResolver();

        $fileSystem = new Filesystem();
        $paths = ['resources/views/my-theme'];
        $extensions = null;
        $viewFinder = new FileViewFinder($fileSystem, $paths, $extensions);

        $dispatcher = new Dispatcher();

        $viewFactory = new Factory($engineResolver, $viewFinder, $dispatcher);

        return new HtmlBuilder($url, $viewFactory);
    }

}