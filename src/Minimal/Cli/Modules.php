<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Core\Collection;
use Maduser\Minimal\Core\Minimal;
use Maduser\Minimal\Core\Module;
use Maduser\Minimal\Core\Route;

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