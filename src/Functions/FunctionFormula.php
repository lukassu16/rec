<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Functions;

interface FunctionFormula
{
    public function findCoeficientsFromPoints(array $points);

    public function findValue(float $arg): float;
}