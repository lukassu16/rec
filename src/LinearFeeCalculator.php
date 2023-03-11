<?php

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Exceptions\RangeNotFoundException;
use PragmaGoTech\Interview\Exceptions\WrongDataException;
use PragmaGoTech\Interview\FeeCalculator;
use PragmaGoTech\Interview\Functions\LinearFunctionFormula;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Validators\LoanProposalValidator;

class LinearFeeCalculator implements FeeCalculator
{
    public function calculate(LoanProposal $application): float
    {
        $term   = $application->term();
        $amount = $application->amount();
        
        if (!LoanProposalValidator::validate($term, $amount))
            throw new WrongDataException('Invalid data.');

        try {
            $points = $this->getNearestPoitnsFromArray($term, $amount);
        } catch (RangeNotFoundException $e) {
            return -1;
        }

        $linearFunction = new LinearFunctionFormula();
        $linearFunction->findCoeficientsFromPoints($points);

        $fee = $linearFunction->findValue($amount);

        return round($fee/5) * 5;
    }

    public function getNearestPoitnsFromArray($term, $amount): array
    {
        $feePoints = App::get('config')[$term];
        
        $smallestAmounts = array_filter(
            array_keys($feePoints),
            function ($key) use ($amount) {
                return $key < $amount;
            }
        );

        $biggestAmounts = array_filter(
            array_keys($feePoints),
            function ($key) use ($amount) {
                return $key > $amount;
            }
        );

        if (empty($smallestAmounts) || empty($biggestAmounts)) {
            throw new RangeNotFoundException('Range was not found current amount');

        }

        $min = max($smallestAmounts);
        $max = min($biggestAmounts);

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