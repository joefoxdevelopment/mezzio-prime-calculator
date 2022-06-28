<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Calculator\Calculator;
use App\Dal\KnownPrimesInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CalculatorFactory
{
    public function __invoke(ContainerInterface $container): Calculator
    {
        /** @var KnownPrimesInterface */
        $knownPrimes = $container->get(KnownPrimesInterface::class);

        return new Calculator($knownPrimes);
    }
}
