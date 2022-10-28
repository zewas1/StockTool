<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrackedStockRequests\CreateTrackedStockRequest;
use App\Http\Requests\TrackedStockRequests\FollowTrackedStockRequest;
use App\Http\Requests\TrackedStockRequests\UpdateTrackedStockRequest;
use App\Http\Services\TrackedStockService;
use App\Http\Services\UserTrackedStockService;
use App\Repositories\TrackedStockRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackedStockController extends Controller
{
    /**
     * @var TrackedStockRepository
     */
    private TrackedStockRepository $trackedStockRepository;

    /**
     * @var UserTrackedStockService
     */
    private UserTrackedStockService $userTrackedStockService;

    /**
     * @var TrackedStockService
     */
    private TrackedStockService $trackedStockService;

    /**
     * @param TrackedStockRepository  $trackedStockRepository
     * @param UserTrackedStockService $userTrackedStockService
     * @param TrackedStockService     $trackedStockService
     */
    public function __construct(
        TrackedStockRepository  $trackedStockRepository,
        UserTrackedStockService $userTrackedStockService,
        TrackedStockService     $trackedStockService
    ) {
        $this->trackedStockRepository = $trackedStockRepository;
        $this->userTrackedStockService = $userTrackedStockService;
        $this->trackedStockService = $trackedStockService;
    }

    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return response()->json($this->trackedStockRepository->all());
    }

    /**
     * @return JsonResponse
     */
    public function listUsers(): JsonResponse
    {
        return response()->json($this->userTrackedStockService->getTrackedStocks(auth()->user()->id));
    }

    /**
     * @param CreateTrackedStockRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreateTrackedStockRequest $request): JsonResponse
    {
        try {
            $this->authorize('create', auth()->user());
        } catch (AuthorizationException $exception) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'error' => $exception->response(),
            ]);
        }

        $status = $this->trackedStockService->storeTrackedStock(
            auth()->user()->id,
            $request->get('stock_name'),
            $request->get('stock_symbol')
        );

        return response()->json([
            'status' => $status,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function edit(Request $request): JsonResponse
    {
        try {
            $this->authorize('edit', auth()->user());
        } catch (AuthorizationException $exception) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'error' => $exception->response(),
            ]);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'stock' => $this->trackedStockRepository->findOneBy(
                'id',
                $request->get('stock_id')),
        ]);
    }

    /**
     * @param UpdateTrackedStockRequest $request
     *
     * @return JsonResponse
     */
    public function update(UpdateTrackedStockRequest $request): JsonResponse
    {
        try {
            $this->authorize('update', auth()->user());
        } catch (AuthorizationException $exception) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'error' => $exception->response(),
            ]);
        }

        $status = $this->trackedStockService->updateTrackedStock(
            auth()->user()->id,
            $request->get('stock_id'),
            $request->get('data')
        );

        return response()->json([
            'status' => $status,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $this->authorize('delete', auth()->user());
        } catch (AuthorizationException $exception) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'error' => $exception->response(),
            ]);
        }

        $this->trackedStockRepository->delete($request->get('stock_id'));

        return response()->json([
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }

    /**
     * @param FollowTrackedStockRequest $request
     *
     * @return JsonResponse
     */
    public function follow(FollowTrackedStockRequest $request): JsonResponse
    {
        $status = $this->userTrackedStockService->followTrackedStock(
            auth()->user()->id,
            $request->get('stock_id')
        );

        return response()->json([
            'status' => $status,
        ]);
    }
}
