<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Collections\Collection;
use Maduser\Minimal\Apps\Minimal;
use Maduser\Minimal\Apps\Module;
use Maduser\Minimal\Routers\Route;

class Modules
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
        $modules = $this->minimal->getModules()->getModules()->getArray();

        foreach ($modules as $module) {
            /** @var Module $module */
            $array[] = [
                'name' => $module->getName(),
                'path' => $module->getPath(),
                'config' => $module->getConfigFile(),
                'routes' => $module->getRoutesFile(),
                'providers' => $module->getProvidersFile(),
                'bindings' => $module->getBindingsFile()
            ];

        }

        $this->console->table(
            $array,
            [['Name', 'Path', 'Config', 'Routes', 'Providers', 'Bindings']]
        );
    }

}