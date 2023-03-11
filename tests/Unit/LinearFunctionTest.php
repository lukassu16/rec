<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Functions\LinearFunctionFormula;

class LinearFunctionTest extends TestCase
{
    public function test_linear_function_formula_correctly_set_a_and_if_ax_is_not_equal_to_bx()
    {
        $firstPoint     = array('x' => rand(1, 10), 'y' => rand(1, 10));
        $secondPoint    = array('x' => rand(11, 20), 'y' => rand(1, 20));

        $linearFunction = new LinearFunctionFormula();
        $linearFunction->findCoeficientsFromPoints(
            array($firstPoint, $secondPoint)
        );

        $this->assertEquals($firstPoint['y'], $linearFunction->findValue($firstPoint['x']));
        $this->assertEquals($secondPoint['y'], $linearFunction->findValue($secondPoint['x']));
    }

    public function test_linear_function_formula_throws_error_if_ax_is_equal_to_bx()
    {
        $randomX        = rand(1,10);
        $firstPoint     = array('x' => $randomX, 'y' => rand(1, 10));
        $secondPoint    = array('x' => $randomX, 'y' => rand(1, 10));

        $this->expectException(Exception::class);

        $linearFunction = new LinearFunctionFormula();
        $linearFunction->findCoeficientsFromPoints(
            array($firstPoint, $secondPoint)
        );
    }
}