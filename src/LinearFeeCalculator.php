<?php

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\FeeCalculator;
use PragmaGoTech\Interview\Model\LoanProposal;

class LinearFeeCalculator implements FeeCalculator
{
    public function calculate(LoanProposal $application): float
    {
        // validation...
        $term   = $application->term();
        $amount = $application->amount();
        
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

        // y = ax + b
        $a = ($feeForMax - $feeForMin ) / ($max - $min);
        $b = $feeForMin - $a * $min;
        
        $fee = $a * $amount + $b;

        return round($fee/5) * 5;
    }
}