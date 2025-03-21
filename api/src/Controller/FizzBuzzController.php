<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ValidationDto;
use App\Query\FizzBuzzQuery;
use App\QueryBus\QueryBus;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[
    Route('/api/1/fizzbuzz', name: 'api_v1_fizzbuzz', methods: ['GET'], priority: 10),
    OA\Tag(name: 'FizzBuzz'),

    OA\Response(
        response: Response::HTTP_OK,
        description: 'FizzBuzz result',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(type: 'string')
        )
    ),
    OA\Response(
        response: Response::HTTP_UNPROCESSABLE_ENTITY,
        description: 'Validation error',
        content: new OA\JsonContent(
            ref: new Model(type: ValidationDto::class)
        )
    ),
    OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Bad request error',
        content: new OA\JsonContent(
            type: 'string',
        )
    ),
]
class FizzBuzzController extends AbstractApiController
{
    public function __construct(
        protected SerializerInterface $serializer,
        protected ValidatorInterface $validator,
        protected QueryBus $queryBus,
    ) {
    }

    public function __invoke(
        #[MapQueryString] FizzBuzzQuery $query,
    ): JsonResponse {
        try {
            $result = $this->queryBus->dispatch($query);
        } catch (ValidationFailedException $e) {
            return new JsonResponse($e->getViolations(), Response::HTTP_BAD_REQUEST);
        } catch (NotEncodableValueException|ExceptionInterface|\TypeError|\RuntimeException) {
            return new JsonResponse('Invalid request', Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($result);
    }
}
