<?php

declare(strict_types=1);

namespace App\Builders;

use Carbon\Carbon;

class UserTrackedStockBuilder
{

    /**
     * @param int $userId
     * @param int $stockId
     *
     * @return array
     */
    public function build(int $userId, int $stockId): array
    {
        return [
            'user_id' => $userId,
            'tracked_stock_id' => $stockId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
