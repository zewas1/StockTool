<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockOwnershipRequests\PurchaseRequest;
use App\Http\Services\StockPurchaseService;
use Exception;
use Illuminate\Http\JsonResponse;

class StockOwnershipController extends Controller
{
    /**
     * @var StockPurchaseService
     */
    private StockPurchaseService $purchaseService;

    /**
     * @param StockPurchaseService $purchaseService
     */
    public function __construct(StockPurchaseService $purchaseService){
        $this->purchaseService = $purchaseService;
    }

    /**
     * @param PurchaseRequest $request
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function buyStock(PurchaseRequest $request)
    {
        return response()->json([
            'status' => $this->purchaseService->purchaseStock(
                auth()->user(),
                $request->get('amount'),
                $request->get('stock_symbol'),
                $request->get('tracked_stock_id')
            )
        ]);
    }

    public function sellStock(){
        //TODO
    }
}
