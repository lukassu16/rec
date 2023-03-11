<?php

namespace PragmaGoTech\Interview\Functions;

class LinearFunctionFormula implements FunctionFormula
{
    /**
     * y = ax + b
     */
    public $a;
    public $b;
    
    public function findCoeficientsFromPoints($points)
    {
        $this->a = ($points[0]['y'] - $points[1]['y']) /
            ($points[0]['x'] - $points[1]['x']);

        $this->b = $points[1]['y'] - $this->a * $points[1]['x'];
    }

    public function findValue(float $arg): float
    {
        return $this->a * $arg + $this->b;
    }
}