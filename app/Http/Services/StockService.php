<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Factories\StockFactory;
use App\Models\Stock;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class StockService
{
    private Client $client;

    private string $iexToken;

    private string $iexUri;

    private StockFactory $stockFactory;

    public function __construct(Client $client,StockFactory $stockFactory){
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
        $requestUrl = $this->getRequestUrl($stockSymbol);

        try {
            $response = $this->client->get($requestUrl);
        } catch (GuzzleException $error){
            throw new RuntimeException($error->getResponse()->getBody()->getContents());
        }

        return $this->stockFactory->create(json_decode($response->getBody()->getContents(), true));

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
}
