<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\RetrieveStockRequest;
use App\Http\Services\StockService;
use Symfony\Component\HttpFoundation\JsonResponse;

class StockController
{
    private StockService $stockService;

    public function __construct(StockService $stockService){
        $this->stockService = $stockService;
    }

    public function getStock(RetrieveStockRequest $request): JsonResponse
    {
        return response()->json($this->stockService->retrieveStockInformation($request->get('stock_symbol')));
    }
}
