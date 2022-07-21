<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Calculator\Calculator;
use App\Handler\IsPrime;
use App\Handler\IsPrimeFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class IsPrimeFactoryTest extends TestCase
{
    private $factory;
    private $container;

    public function setUp(): void
    {
        $this->container = $this->prophesize(ContainerInterface::class);

        $this->factory = new IsPrimeFactory();
    }

    public function testInvokeReturnsIsPrime(): void
    {
        $calculator = $this->prophesize(Calculator::class);

        $this->container->get(Calculator::class)
            ->willReturn($calculator->reveal());

        $isPrime = ($this->factory)($this->container->reveal());

        $this->assertInstanceOf(IsPrime::class, $isPrime);
    }
}
