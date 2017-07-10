<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Core\IOC;
use Maduser\Minimal\Core\Minimal;

class Providers
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
        $thead = [['Alias', 'Provider']];
        $tbody = [];

        $items = IOC::config('providers');

        foreach ($items as $key => $value) {
            $tbody[] = [$key, $value];
        }

        $this->console->table($tbody, $thead);
    }

}