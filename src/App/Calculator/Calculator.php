<?php

declare(strict_types=1);

namespace App\Calculator;

use Assert\Assert;
use App\Dal\KnownPrimes as KnownPrimesDal;
use App\Result\Result;

class Calculator
{
    private $knownPrimes;

    public function __construct(KnownPrimesDal $knownPrimes)
    {
        $this->knownPrimes = $knownPrimes;
    }

    public function isPrime(int $number): Result
    {
        $this->validateNumber($number);

        $knownPrimesResult = $this->knownPrimes->get($number);

        if (null !== $knownPrimesResult) {
            return $knownPrimesResult;
        }

        $startTime = microtime(true);

        $isPrime = true;

        for ($i = 2; $number > $i; $i++) {
            if ((float) ($number / $i) === (float) ((int) ($number / $i))) {
                $isPrime = false;
                break;
            }
        }

        $calculationTime = microtime(true) - $startTime;

        return Result::createCalculatedResult($number, $isPrime, $calculationTime);
    }

    private function validateNumber(int $number): void
    {
        Assert::that($number)->min(2);
    }
}
