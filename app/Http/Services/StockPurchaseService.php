<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Builders\OwnedStockBuilder;
use App\Models\Stock;
use App\Models\User;
use App\Repositories\UserOwnedStockRepository;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class StockPurchaseService
{
    /**
     * @var StockService
     */
    private StockService $stockService;

    /**
     * @var UserOwnedStockRepository
     */
    private UserOwnedStockRepository $ownedStockRepository;

    /**
     * @var OwnedStockBuilder
     */
    private OwnedStockBuilder $ownedStockBuilder;

    /**
     * @param StockService $stockService
     * @param UserOwnedStockRepository $ownedStockRepository
     * @param OwnedStockBuilder $ownedStockBuilder
     */
    public function __construct(
        StockService $stockService,
        UserOwnedStockRepository $ownedStockRepository,
        OwnedStockBuilder $ownedStockBuilder
    ) {
        $this->stockService = $stockService;
        $this->ownedStockRepository = $ownedStockRepository;
        $this->ownedStockBuilder = $ownedStockBuilder;
    }

    /**
     * @param User $user
     * @param string $amount
     * @param string $stockSymbol
     * @param int $trackedStockId
     *
     * @return int
     *
     * @throws Exception
     */
    public function purchaseStock(User $user, string $amount, string $stockSymbol, int $trackedStockId): int
    {
        $stock = $this->stockService->retrieveStockInformation($stockSymbol);

        $this->validateBalance($stock, $amount, $user);
        $data = $this->ownedStockBuilder->build($trackedStockId, $user->id, (int) $amount);
        $this->ownedStockRepository->create($data);

        return Response::HTTP_OK;
    }

    /**
     * @param Stock $stock
     * @param string $amount
     * @param User $user
     *
     * @return void
     *
     * @throws Exception
     */
    private function validateBalance(Stock $stock, string $amount, User $user): void
    {
        if ($stock->latest_price * $amount < $user->balance) {
            throw new Exception('Insufficient balance', Response::HTTP_BAD_REQUEST);
        }
    }
}
