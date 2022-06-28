<?php

declare(strict_types=1);

namespace App\Dal;

use App\Result\Result;

class KnownPrimes implements KnownPrimesInterface
{
    private const KNOWN_RESULTS = [
        2  => true,
        3  => true,
        4  => false,
        5  => true,
        6  => false,
        7  => true,
        8  => false,
        9  => false,
        10 => false,
        11 => true,
        12 => false,
        13 => true,
        14 => false,
        15 => false,
        16 => false,
        17 => true,
        18 => false,
        19 => true,
        20 => false,
    ];

    /** @SuppressWarnings(PHPMD.StaticAccess) */
    public function get(int $number): ?Result
    {
        if (array_key_exists($number, self::KNOWN_RESULTS)) {
            return Result::createDatastoreResult($number, self::KNOWN_RESULTS[$number]);
        }

        return null;
    }
}
