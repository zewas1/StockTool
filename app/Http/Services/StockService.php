<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Factories\StockFactory;
use App\Models\Stock;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use App\Constants\StockConstants;

class StockService
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var string
     */
    private string $iexToken;

    /**
     * @var string
     */
    private string $iexUri;

    /**
     * @var StockFactory
     */
    private StockFactory $stockFactory;

    /**
     * @param Client $client
     * @param StockFactory $stockFactory
     */
    public function __construct(Client $client, StockFactory $stockFactory)
    {
        $this->client = $client;
        $this->iexToken = env('IEX_API_TOKEN');
        $this->iexUri = env('IEX_API_URI');
        $this->stockFactory = $stockFactory;
    }

    /**
     * @param string $stockSymbol
     *
     * @return Stock
     */
    public function retrieveStockInformation(string $stockSymbol): Stock
    {
        $stockCacheKey = $this->getStockCacheKey($stockSymbol);
        $stock = $this->getStockFromCache($stockCacheKey);

        if ($stock) {
            return $stock;
        }

        $requestUrl = $this->getRequestUrl($stockSymbol);
        $response = $this->getResponse($requestUrl);
        $stock = $this->stockFactory->create(json_decode($response->getBody()->getContents(), true));

        $this->placeStockInCache($stockCacheKey, $stock);

        return $stock;

    }

    /**
     * @param string $stockSymbol
     *
     * @return string
     */
    private function getRequestUrl(string $stockSymbol): string
    {
        return $this->iexUri . $stockSymbol . '/quote?token=' . $this->iexToken;
    }

    /**
     * @param string $stockSymbol
     *
     * @return string
     */
    private function getStockCacheKey(string $stockSymbol): string
    {
        return StockConstants::STOCK_CACHE_KEY . ' ' . $stockSymbol;
    }

    /**
     * @param string $requestUrl
     *
     * @return ResponseInterface
     */
    private function getResponse(string $requestUrl): ResponseInterface
    {
        try {
            $response = $this->client->get($requestUrl);
        } catch (GuzzleException $error) {
            throw new RuntimeException($error->getResponse()->getBody()->getContents());
        }

        return $response;
    }

    /**
     * @param string $stockCacheKey
     * @param Stock $stock
     *
     * @return void
     */
    private function placeStockInCache(string $stockCacheKey, Stock $stock): void
    {
        Cache::put(
            $stockCacheKey,
            $stock,
            StockConstants::STOCK_CACHE_TIME_IN_SECONDS
        );
    }

    /**
     * @param string $stockCacheKey
     *
     * @return Stock|null
     */
    private function getStockFromCache(string $stockCacheKey): ?Stock
    {
        return Cache::get($stockCacheKey);
    }
}
