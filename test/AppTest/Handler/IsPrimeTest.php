<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Calculator\Calculator;
use App\Handler\IsPrime;
use App\Result\Result;
use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IsPrimeTest extends TestCase
{
    private $calculator;
    private $isPrime;
    private $request;

    public function setUp(): void
    {
        $this->calculator = $this->prophesize(Calculator::class);
        $this->request    = $this->prophesize(ServerRequestInterface::class);

        $this->isPrime = new IsPrime($this->calculator->reveal());
    }

    private function testImplementsRequestHandlerInterface(): void
    {
        $this->assertInstanceOf(RequestHandlerInterface::class, $this->isPrime);
    }

    /**
     * @dataProvider provideInvalidQueryParams
     */
    public function testHandleReturnsBadRequestResponseOnInvalidRequest(array $queryParams, string $message): void
    {
        $this->request->getQueryParams()
            ->willReturn($queryParams);

        $response = $this->isPrime->handle($this->request->reveal());

        $this->assertEquals(
            400,
            $response->getStatusCode()
        );

        $this->assertEquals(
            $message,
            $response->getPayload()['error']
        );
    }

    public function testHandleReturnsInternalServerErrorResponseOnCalculatorError(): void
    {
        $this->request->getQueryParams()
            ->willReturn([
                'number' => 33,
            ]);

        $this->calculator->isPrime(Argument::type('int'))
            ->willThrow(new Exception('Error message'));

        $response = $this->isPrime->handle($this->request->reveal());

        $this->assertEquals(
            500,
            $response->getStatusCode()
        );

        $this->assertEquals(
            'Error message',
            $response->getPayload()['error']
        );
    }

    public function testHandleReturnsOkResponseOnSuccess(): void
    {
        $this->request->getQueryParams()
            ->willReturn([
                'number' => 33,
            ]);

        $result = $this->prophesize(Result::class);
        $result->getResultArray()->willReturn(['results']);

        $this->calculator->isPrime(Argument::type('int'))
            ->willReturn($result->reveal());

        $response = $this->isPrime->handle($this->request->reveal());

        $this->assertEquals(
            200,
            $response->getStatusCode()
        );

        $this->assertEquals(
            ['results'],
            $response->getPayload()
        );
    }

    public function provideInvalidQueryParams(): array
    {
        return [
            '\'number\' key not set' => [
                [],
                'Query parameter "number" not set',
            ],
            '\'number\' not integerish' => [
                ['number' => 'not an integerish'],
                'Query parameter "number" must be an integer greater than or equal to 2 and less than or equal to 10,000,000',
            ],
            '\'number\' below 2' => [
                ['number' => -200],
                'Query parameter "number" must be an integer greater than or equal to 2 and less than or equal to 10,000,000',
            ],
            '\'number\' above 10,000,000' => [
                ['number' => 15000000],
                'Query parameter "number" must be an integer greater than or equal to 2 and less than or equal to 10,000,000',
            ],
        ];
    }
}
