<?php

declare(strict_types=1);

namespace App\Test\Dal;

use App\Dal\KnownPrimes;
use App\Result\Result;
use PHPUnit\Framework\TestCase;

class KnownPrimesTest extends TestCase
{
    private $dal;

    public function setUp(): void
    {
        $this->dal = new KnownPrimes();
    }

    /**
     * @dataProvider provideKnownResults
     */
    public function testGetReturnsResultsWhenKnownPrimeRequested(int $number, bool $isPrime): void
    {
        $result = $this->dal->get($number);

        $this->assertInstanceOf(Result::class, $result);
        $this->assertEquals(
            [
                'number'            => $number,
                'isPrime'           => $isPrime,
                'calculationMethod' => Result::METHOD_DATASTORE,
                'calculationTime'   => null,
            ],
            $result->getResultArray()
        );
    }

    public function testGetReturnsNullWhenUnknownPrimeRequested(): void
    {
        $result = $this->dal->get(101);

        $this->assertNull($result);
    }

    public function provideKnownResults(): array
    {
        return [
            [2, true],
            [3, true],
            [4, false],
            [17, true],
        ];
    }
}
