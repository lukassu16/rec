<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\App;
use PragmaGoTech\Interview\Functions\LinearFunctionFormula;
use PragmaGoTech\Interview\LinearFeeCalculator;
use PragmaGoTech\Interview\Model\LoanProposal;

class FeeCalculationTest extends TestCase
{
    public function test_test_test()
    {
        $testFeeArray = array(
            12 => [
                1000 => 120,
                2000 => 140,
                3000 => 150,
                4000 => 150,
                5000 => 180,
                6000 => 200,
                7000 => 250
            ],
            24 => [
                1000 => 240,
                2000 => 280,
                3000 => 300,
                4000 => 300,
                5000 => 260,
                6000 => 400,
                7000 => 500
            ]
        );

        App::bind('config', $testFeeArray);

        $calculator = new LinearFeeCalculator();

        $application = new LoanProposal(12, 2500);

        $fee = $calculator->calculate($application);

        $this->assertEquals($fee, 145);

        $secondApplication = new LoanProposal(24, 3333);

        $fee = $calculator->calculate($secondApplication);

        $this->assertEquals($fee, 300);
    }
}