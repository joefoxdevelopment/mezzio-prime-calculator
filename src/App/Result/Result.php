<?php

declare(strict_types=1);

namespace App\Result;

class Result
{
    public const METHOD_CALCULATED = 'Calculated';
    public const METHOD_DATASTORE  = 'Datastore';

    private $number;
    private $isPrime;
    private $calculationMethod;
    private $calculationTime = null;

    public function __construct(int $number, bool $isPrime, string $calculationMethod, ?float $calculationTime = null)
    {
        $this->number            = $number;
        $this->isPrime           = $isPrime;
        $this->calculationMethod = $calculationMethod;
        $this->calculationTime   = $calculationTime;
    }

    public function getResultArray(): array
    {
        return [
            'number'            => $this->number,
            'isPrime'           => $this->isPrime,
            'calculationMethod' => $this->calculationMethod,
            'calculationTime'   => $this->calculationTime,
        ];
    }

    public static function createCalculatedResult(int $number, bool $isPrime, float $calculationTime): self
    {
        return new self($number, $isPrime, self::METHOD_CALCULATED, $calculationTime);
    }

    public static function createDatastoreResult(int $number, bool $isPrime): self
    {
        return new self($number, $isPrime, self::METHOD_DATASTORE);
    }
}
