<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Validators;

class LoanProposalValidator
{
    static function validate($term, $amount)
    {
        if ($term != 12 && $term != 24)
            return false;

        if ($amount < 1000 || $amount > 20000)
            return false;

        return true;
    }
}