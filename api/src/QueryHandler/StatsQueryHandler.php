<?php

declare(strict_types=1);

namespace App\QueryHandler;

use App\Dto\StatsResultDto;
use App\Query\StatsQuery;
use App\Repository\StatRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class StatsQueryHandler
{
    public function __construct(
        private StatRepository $repository,
    ) {
    }

    public function __invoke(StatsQuery $query): ?StatsResultDto
    {
        $stat = $this->repository->findTopRequest();

        return $stat ? new StatsResultDto($stat) : null;
    }
}
