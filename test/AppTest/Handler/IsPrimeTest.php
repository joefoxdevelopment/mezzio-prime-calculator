<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Calculator\Calculator;
use App\Handler\IsPrime;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

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

    public function testHandleReturnBadRequestResponseOnInvalidRequest(): void
    {
        $this->request->getQueryParams()->willReturn([]);

        $response = $this->isPrime->handle($this->request->reveal());

        $this->assertEquals(
            400,
            $response->getStatusCode()
        );
    }
}
