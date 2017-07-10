<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Core\IOC;
use Maduser\Minimal\Core\Minimal;

class Bindings
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

        $this->list();
    }

    protected function list()
    {
        $thead = [['Alias', 'Binding']];
        $tbody = [];

        $items = IOC::config('bindings');

        foreach ($items as $key => $value) {
            $tbody[] = [$key, $value];
        }

        $this->console->table($tbody, $thead);
    }

}
