<?php

declare(strict_types=1);

use App\Calculator\Calculator;
use App\Dal\KnownPrimesInterface;
use App\Result\Result;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class CalculatorTest extends TestCase
{
    private $calculator;
    private $knownPrimes;

    public function setUp(): void
    {
        $this->knownPrimes = $this->prophesize(KnownPrimesInterface::class);

        $this->calculator = new Calculator($this->knownPrimes->reveal());
    }

    /** @dataProvider provideInvalidNumber */
    public function testIsPrimeThrowsInvalidArgumentExceptionWithInvalidNumber(int $number): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->isPrime($number);
    }

    public function provideInvalidNumber(): array
    {
        return [[1], [0], [-1], [-2], [-3], [-4], [-5]];
    }

    /** @dataProvider provideExpectedResults */
    public function testIsPrimeReturnsResultFromDal(int $number, bool $isPrime): void
    {
        $expectedResult = Result::createDatastoreResult($number, $isPrime);

        $this->knownPrimes->get($number)->willReturn($expectedResult);

        $actualResult = $this->calculator->isPrime($number);

        $this->assertSame($expectedResult, $actualResult);
    }

    /** @dataProvider provideExpectedResults */
    public function testIsPrimeReturnsCalculatedResult(int $number, bool $isPrime): void
    {
        $this->knownPrimes->get($number)->willReturn(null);

        $result = $this->calculator->isPrime($number);

        $resultArray = $result->getResultArray();

        $this->assertEquals($number, $resultArray['number']);
        $this->assertEquals($isPrime, $resultArray['isPrime']);
        $this->assertEquals(Result::METHOD_CALCULATED, $resultArray['calculationMethod']);
        $this->assertIsFloat($resultArray['calculationTime']);
    }

    public function provideExpectedResults(): array
    {
        return [
            [5, true],
            [6, false],
            [7, true],
            [17, true],
            [9999, false],
            [10007, true],
        ];
    }
}
