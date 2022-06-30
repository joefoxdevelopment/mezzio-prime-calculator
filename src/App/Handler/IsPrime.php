<?php

declare(strict_types=1);

namespace App\Handler;

use App\Calculator\Calculator;
use Assert\Assert;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use InvalidArgumentException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IsPrime implements RequestHandlerInterface
{
    /** @var Calculator */
    private $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $this->validateRequest($request);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse(
                [
                    'error' => $e->getMessage(),
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        try {
            $result = $this->calculator->isPrime((int) $request->getQueryParams()['number']);
        } catch (Exception $e) {
            return new JsonResponse(
                [
                    'error' => $e->getMessage(),
                ],
                StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR
            );
        }

        return new JsonResponse(
            $result->getResultArray(),
            StatusCodeInterface::STATUS_OK
        );
    }

    private function validateRequest(ServerRequestInterface $request): void
    {
        $queryParams = $request->getQueryParams();

        Assert::that($queryParams, 'Query parameter "number" not set')
            ->keyExists('number');

        Assert::that(
            $queryParams['number'],
            'Query parameter "number" must be an integer greater than or equal to 2 and less than or equal'
            . ' to 10,000,000'
        )
            ->integerish()
            ->min(2)
            ->max(10000000);
    }
}
