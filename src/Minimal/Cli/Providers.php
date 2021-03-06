<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Framework\Facades\IOC;
use Maduser\Minimal\Framework\Minimal;

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

        $this->all();
    }

    protected function all()
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