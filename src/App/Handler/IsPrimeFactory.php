<?php

declare(strict_types=1);

namespace App\Handler;

use App\Calculator\Calculator;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IsPrimeFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        /** @var Calculator */
        $calculator = $container->get(Calculator::class);

        return new IsPrime($calculator);
    }
}
