<?php

declare(strict_types=1);

namespace App\Factories;

use App\Models\Stock;

class StockFactory implements FactoryInterface
{
    /**
     * @param array $data
     *
     * @return Stock
     */
    public function create(array $data): Stock
    {
        $stock = new Stock();

        $stock->change_value = $data['change'];
        $stock->change_percent = $data['changePercent'];
        $stock->company_name = $data['companyName'];
        $stock->currency = $data['currency'];
        $stock->latest_price = $data['latestPrice'];
        $stock->symbol = $data['symbol'];
        $stock->year_high = $data['week52High'];
        $stock->year_low = $data['week52Low'];
        $stock->ytd_change = $data['ytdChange'];
        $stock->is_us_market_open = $data['isUSMarketOpen'];

        return $stock;
    }
}
