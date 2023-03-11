<?php

require_once 'vendor/autoload.php';
require_once 'core/bootstrap.php';

use PragmaGoTech\Interview\LinearFeeCalculator;
use PragmaGoTech\Interview\Model\LoanProposal;

$calculator = new LinearFeeCalculator();

$application = new LoanProposal(24, 4440);

$fee = $calculator->calculate($application);

echo($fee);
