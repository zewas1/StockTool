<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Builders\UserTrackedStockBuilder;
use App\Models\UserTrackedStock;
use App\Repositories\TrackedStockRepository;
use App\Repositories\UserTrackedStockRepository;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;

class UserTrackedStockService
{

    /**
     * @var UserTrackedStockRepository
     */
    private UserTrackedStockRepository $userTrackedStockRepository;

    /**
     * @var TrackedStockRepository
     */
    private TrackedStockRepository $trackedStockRepository;

    /**
     * @var UserTrackedStockBuilder
     */
    private UserTrackedStockBuilder $userTrackedStockBuilder;

    /**
     * @param UserTrackedStockRepository $userTrackedStockRepository
     * @param TrackedStockRepository $trackedStockRepository
     * @param UserTrackedStockBuilder $userTrackedStockBuilder
     */
    public function __construct(
        UserTrackedStockRepository $userTrackedStockRepository,
        TrackedStockRepository     $trackedStockRepository,
        UserTrackedStockBuilder    $userTrackedStockBuilder
    ) {
        $this->userTrackedStockRepository = $userTrackedStockRepository;
        $this->trackedStockRepository = $trackedStockRepository;
        $this->userTrackedStockBuilder = $userTrackedStockBuilder;
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public function getTrackedStocks(int $userId): array
    {
        $userTrackedStockIds = $this->userTrackedStockRepository->findAllIdsBy(
            'user_id',
            (string) $userId,
            'tracked_stock_id'
        );

        return $this->getUserTrackedStocks($userTrackedStockIds);
    }

    /**
     * @param UserTrackedStock|Collection|null $userTrackedStockIds
     *
     * @return array
     */
    private function getUserTrackedStocks(
        UserTrackedStock|Collection|null $userTrackedStockIds
    ): array {
        $userTrackedStocks = [];

        foreach ($userTrackedStockIds as $userTrackedStockId) {
            $userTrackedStocks[] = $this->trackedStockRepository->findOneBy('id', $userTrackedStockId);
        }

        return $userTrackedStocks;
    }

    /**
     * @param int $userId
     * @param int $stockId
     *
     * @return int
     */
    public function followTrackedStock(int $userId, int $stockId): int
    {
        $trackedStock = $this->userTrackedStockRepository->findOneByMany([
            'user_id' => $userId,
            'tracked_stock_id' => $stockId,
        ]);

        if ($trackedStock->isNotEmpty()) {
            return Response::HTTP_BAD_REQUEST;
        }

        $data = $this->userTrackedStockBuilder->build($userId, $stockId);
        $this->userTrackedStockRepository->create($data);

        return Response::HTTP_OK;
    }
}
