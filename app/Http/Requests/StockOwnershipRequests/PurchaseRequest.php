<?php

declare(strict_types=1);

namespace App\Http\Requests\StockOwnershipRequests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'tracked_stock_id' => 'required|int',
            'stock_symbol' => 'required|string',
            'amount' => 'required|int|min:0'
        ];
    }
}
