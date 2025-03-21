<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\StatsResultDto;
use App\Query\StatsQuery;
use App\QueryBus\QueryBus;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[
    Route('/api/1/stats', name: 'api_v1_stats', methods: ['GET'], priority: 10),
    OA\Tag(name: 'Stats'),
    OA\Response(
        response: Response::HTTP_OK,
        description: 'Stats result',
        content: new OA\JsonContent(
            ref: new Model(type: StatsResultDto::class)
        )
    ),
]
class StatsController extends AbstractApiController
{
    public function __construct(
        protected SerializerInterface $serializer,
        protected QueryBus $queryBus,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        try {
            $result = $this->queryBus->dispatch(new StatsQuery());
        } catch (ExceptionInterface|\RuntimeException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return JsonResponse::fromJsonString($this->serializer->serialize($result, 'json'));
    }
}
