<?php

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\FeeCalculator;
use PragmaGoTech\Interview\Functions\LinearFunctionFormula;
use PragmaGoTech\Interview\Model\LoanProposal;

class LinearFeeCalculator implements FeeCalculator
{
    public function calculate(LoanProposal $application): float
    {
        // validation...
        $term   = $application->term();
        $amount = $application->amount();
        
        $points = $this->getNearestPoitnsFromArray($term, $amount);

        $linearFunction = new LinearFunctionFormula();
        $linearFunction->findCoeficientsFromPoints($points);

        $fee = $linearFunction->findValue($amount);

        return round($fee/5) * 5;
    }

    public function getNearestPoitnsFromArray($term, $amount): array
    {
        $feePoints = App::get('config')[$term];
        
        $min = 
            max(
                array_filter(
                    array_keys($feePoints),
                    function ($key) use ($amount) {
                        return $key < $amount;
                    }
                )
            );

        $max = 
            min(
                array_filter(
                    array_keys($feePoints),
                    function ($key) use ($amount) {
                        return $key > $amount;
                    }
                )
            );

        $feeForMin = $feePoints[$min];
        $feeForMax = $feePoints[$max];
        
        return [
            0 => [
                'x' => $max,
                'y' => $feeForMax
            ],
            1 => [
                'x' => $min,
                'y' => $feeForMin,
            ]
        ];
    }
}