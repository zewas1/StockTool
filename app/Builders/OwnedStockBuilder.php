<?php

declare(strict_types=1);

namespace App\Builders;

use Carbon\Carbon;

class OwnedStockBuilder
{
    /**
     * @param int $trackedStockId
     * @param int $userId
     * @param int $amount
     *
     * @return array
     */
    public function build(int $trackedStockId, int $userId, int $amount): array
    {
        return [
            'tracked_stock_id' => $trackedStockId,
            'user_id' => $userId,
            'amount' => $amount,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
