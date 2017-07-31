<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Apps\Minimal;

class Config
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

    public function all()
    {
        $thead = [['Alias', 'Value']];
        $tbody = [];

        $items = $this->array_flat($this->minimal->getConfig()->getItems());

        foreach ($items as $key => $value) {
            $tbody[] = [$key, $value];
        }

        $this->console->table($tbody, $thead);
    }

    public function array_flat($array, $prefix = '')
    {
        $result = array();

        foreach ($array as $key => $value) {
            $new_key = $prefix . (empty($prefix) ? '' : '.') . $key;

            if (is_array($value)) {
                $result = array_merge($result, $this->array_flat($value, $new_key));
            } else {
                $result[$new_key] = $value;
            }
        }

        return $result;
    }
}