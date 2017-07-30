<?php namespace Maduser\Minimal\Benchmark;

/**
 * Class Benchmark
 *
 * @package Maduser\Minimal\Benchmark
 */
class Benchmark
{
    /**
     * @var array
     */
    protected $benchmarks = [];

    /**
     * @return array
     */
    public function getBenchmarks()
    {
        return $this->benchmarks;
    }

    /**
     * @param $name
     * @param $time
     */
    public function addBenchmark($name, $time)
    {
        $this->benchmarks[] = [$name, $time];
    }

    /**
     * @param $key
     */
    public function mark($key)
    {
        $this->addBenchmark($key, microtime(true)*1000);
    }

    public function getExecutionTime()
    {
        $marks = $this->getBenchmarks();
        $count = count($marks);
        return $marks[$count - 1][1] - $marks[0][1];
    }

    public function getPeriod($marks, $i)
    {
        if ($i > 0) {
            return round($marks[$i][1] - $marks[$i-1][1], 3);
        }

        return 0;
    }

    public function getPercents($mark)
    {
        $total = $this->getExecutionTime();

        return round(($mark[2] / $total) * 100, 1);
    }

    /**
     * @param $string
     *
     * @param $placeholder
     *
     * @return mixed
     */
    public function addBenchmarkInfo($string, $placeholder)
    {
        $marks = $this->getBenchmarks();
        $i = 0;
        $str = '';

        foreach ($marks as $mark) {
            $mark[] = $this->getPeriod($marks, $i++);
            $mark[] = $this->getPercents($mark);
            $str .= '<span style="display: block; text-align: left">'
                . str_pad(number_format($mark[2], 3), 7, '0', STR_PAD_LEFT) . ' : '
                . str_pad(number_format($mark[3], 2), 5, '0', STR_PAD_LEFT)
                . '% : ' . $mark[0] . '</span>';
        }

        $str .= '<span style="display: block; text-align: left">'
            . 'Total execution time in ms: '
            . round($this->getExecutionTime(), 4) . '</span>';

        $str = '<div class="text-muted small benchmark">'
            . $str . '</div>';

        return str_replace($placeholder, $str , $string);
    }

    /**
     * @param $end
     * @param $start
     *
     * @return mixed
     */
    public function formatPeriod($end, $start)
    {
        return ($end - $start);
    }

}