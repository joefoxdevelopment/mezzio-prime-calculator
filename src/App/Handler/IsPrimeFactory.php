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
        return new IsPrime($container->get(Calculator::class));
    }
}
