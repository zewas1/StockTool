<?php

declare(strict_types=1);

namespace App\Builders;

use Carbon\Carbon;

class TrackedStockBuilder
{
    /**
     * @param int    $userId
     * @param string $stockName
     * @param string $stockSymbol
     *
     * @return array
     */
    public function build(int $userId, string $stockName, string $stockSymbol): array
    {
        return [
            'user_id' => $userId,
            'stock_name' => $stockName,
            'stock_symbol' => $stockSymbol,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    /**
     * @param int    $userId
     * @param string $stockName
     * @param string $stockSymbol
     * @param bool   $isTrackingEnabled
     *
     * @return array
     */
    public function updateBuild(int $userId, string $stockName, string $stockSymbol, bool $isTrackingEnabled): array
    {
        return [
            'user_id' => $userId,
            'stock_name' => $stockName,
            'stock_symbol' => $stockSymbol,
            'is_tracking_enabled' => $isTrackingEnabled,
            'updated_at' => Carbon::now(),
        ];
    }
}
