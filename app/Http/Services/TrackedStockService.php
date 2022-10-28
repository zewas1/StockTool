<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Builders\TrackedStockBuilder;
use App\Repositories\TrackedStockRepository;
use Symfony\Component\HttpFoundation\Response;

class TrackedStockService
{
    private TrackedStockBuilder $trackedStockBuilder;
    private TrackedStockRepository $trackedStockRepository;

    public function __construct(
        TrackedStockBuilder    $trackedStockBuilder,
        TrackedStockRepository $trackedStockRepository
    ) {
        $this->trackedStockBuilder = $trackedStockBuilder;
        $this->trackedStockRepository = $trackedStockRepository;
    }

    /**
     * @param int    $userId
     * @param string $stockName
     * @param string $stockSymbol
     *
     * @return int
     */
    public function storeTrackedStock(int $userId, string $stockName, string $stockSymbol): int
    {
        $trackedStockData = $this->trackedStockBuilder->build($userId, $stockName, $stockSymbol);
        $this->trackedStockRepository->create($trackedStockData);

        return Response::HTTP_OK;
    }

    /**
     * @param int   $userId
     * @param int   $stockId
     * @param array $data
     *
     * @return int
     */
    public function updateTrackedStock(int $userId, int $stockId, array $data): int
    {
        $trackedStockData = $this->trackedStockBuilder->updateBuild(
            $userId,
            $data['stock_name'],
            $data['stock_symbol'],
            $data['is_tracking_enabled'],
        );
        $this->trackedStockRepository->update($trackedStockData, $stockId);

        return Response::HTTP_OK;
    }
}
