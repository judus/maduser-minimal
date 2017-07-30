<?php namespace Maduser\Minimal\Cli;

class Console
{
    public function write($str, $newLine = true)
    {
        echo $newLine ? $str . "\n" : $str;
    }

    public function table($tbody = [], $thead = [])
    {
        $data = array_merge($tbody, $thead);
        $widths = $this->getColWidths($data);
        $totalWidth = $this->getTotalWidth($widths);

        foreach ($thead as $row) {

            $this->write(' ');
            $this->write($this->pad('', $totalWidth, '-'));

            $str = '|';
            $colIndex = 0;
            foreach ($row as $col) {
                $str .= ' '. $this->pad($col, $widths[$colIndex]) . ' |';
                $colIndex++;
            }

            $this->write($str );

            $this->write($this->pad('', $totalWidth, '-'));

        }

        foreach ($tbody as $row) {
            $str = '|';
            $colIndex = 0;
            foreach ($row as $col) {
                $str .= ' ' . $this->pad($col, $widths[$colIndex], ' ') . ' |';
                $colIndex++;
            }

            $this->write($str);
        }

        $this->write($this->pad('', $totalWidth, '-'));
        $this->write(' ');

    }

    public function pad($str, $length, $ph = ' ')
    {
        return str_pad($str, $length, $ph);
    }

    public function getColWidths($data)
    {
        //var_dump($data);


        $widths = [];

        foreach ($data as $row) {
            $colIndex = 0;
            foreach ($row as $col) {

                if (!isset($widths[$colIndex]) || strlen($col) > $widths[$colIndex]) {
                    $widths[$colIndex] = strlen($col);
                }

                $colIndex++;
            }
        }

        return $widths;

    }

    public function getTotalWidth($widths)
    {
        $total = 0;
        foreach ($widths as $width) {
            $total += $width + 3;
        }
        return $total + 1;
    }
}