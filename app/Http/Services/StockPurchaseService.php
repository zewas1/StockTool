<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Builders\OwnedStockBuilder;
use App\Models\Stock;
use App\Models\User;
use App\Models\UserOwnedStock;
use App\Repositories\UserOwnedStockRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;

class StockPurchaseService
{
    private const DEFAULT_SCALE_PRECISION = 4;

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
        StockService             $stockService,
        UserOwnedStockRepository $ownedStockRepository,
        OwnedStockBuilder        $ownedStockBuilder
    ) {
        $this->stockService = $stockService;
        $this->ownedStockRepository = $ownedStockRepository;
        $this->ownedStockBuilder = $ownedStockBuilder;
    }

    /**
     * @param User $user
     * @param int $amount
     * @param string $stockSymbol
     * @param int $trackedStockId
     *
     * @return int
     *
     * @throws Exception
     */
    public function purchaseStock(User $user, int $amount, string $stockSymbol, int $trackedStockId): int
    {
        $stock = $this->stockService->retrieveStockInformation($stockSymbol);

        $this->validateBalance($stock, $amount, $user);

        //TODO retrieve ownedStock object, if there is none, create new.

        $data = $this->ownedStockBuilder->build($trackedStockId, $user->id, $amount);
        $this->ownedStockRepository->create($data);

        return Response::HTTP_OK;
    }

    /**
     * @throws Exception
     */
    public function sellStock(User $user, int $amount, string $stockSymbol, int $trackedStockId)
    {
        $stock = $this->stockService->retrieveStockInformation($stockSymbol);

        $this->validateAmount($user, $amount, $trackedStockId);
        $this->increaseBalance($user, $this->getIncome($stock, $amount));

        //TODO, further selling flow, deduct amount and update object.
    }

    /**
     * @param Stock $stock
     * @param int $amount
     *
     * @return string
     */
    private function getIncome(Stock $stock, int $amount): string
    {
        return bcmul((string)$stock->latest_price, (string)$amount, self::DEFAULT_SCALE_PRECISION);
    }

    /**
     * @throws Exception
     */
    private function validateAmount(User $user, int $amount, int $trackedStockId): void
    {
        $ownedStock = $this->getOwnedStock($user, $trackedStockId);

        if ($ownedStock->amount < $amount) {
            throw new Exception('Insufficient amount', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Stock $stock
     * @param int $amount
     * @param User $user
     *
     * @return void
     *
     * @throws Exception
     */
    private function validateBalance(Stock $stock, int $amount, User $user): void
    {
        $price = bcmul($stock->latest_price, (string)$amount, self::DEFAULT_SCALE_PRECISION);

        if ($price < $user->balance) {
            throw new Exception('Insufficient balance', Response::HTTP_BAD_REQUEST);
        }

        $this->deductBalance($user, $price);
    }

    /**
     * @param User $user
     * @param string $income
     *
     * @return void
     */
    private function increaseBalance(User $user, string $income): void
    {
        $user->balance = bcadd($user->balance, $income, self::DEFAULT_SCALE_PRECISION);
        $user->save();
    }

    /**
     * @param User $user
     * @param string $price
     *
     * @return void
     */
    private function deductBalance(User $user, string $price): void
    {
        $user->balance = bcsub($user->balance, $price, self::DEFAULT_SCALE_PRECISION);
        $user->save();
    }

    /**
     * @param User $user
     * @param int $trackedStockId
     *
     * @return UserOwnedStock|Collection
     */
    private function getOwnedStock(User $user, int $trackedStockId): UserOwnedStock|Collection
    {
        return $this->ownedStockRepository->findOneByMany([
            'user_id' => $user->id,
            'tracked_stock_id' => $trackedStockId
        ]);
    }
}
