<?php

namespace Maduser\Minimal\Html;

use Collective\Html\FormBuilder;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Maduser\Minimal\Loaders\IOC;

class FormProvider
{
    public function resolve()
    {
        $routeCollection = new RouteCollection();
        $request = new Request();
        $urlGenerator = new UrlGenerator($routeCollection, $request);

        $engineResolver = new EngineResolver();

        $fileSystem = new Filesystem();
        $paths = ['resources/views/my-theme'];
        $extensions = null;
        $viewFinder = new FileViewFinder($fileSystem, $paths, $extensions);

        $dispatcher = new Dispatcher();

        $viewFactory = new Factory($engineResolver, $viewFinder, $dispatcher);

        $csrfToken = md5('APP-KEY-' . time());

        return new FormBuilder(
            IOC::resolve('HtmlBuilder'),
            $urlGenerator,
            $viewFactory,
            $csrfToken,
            $request
        );
    }
}