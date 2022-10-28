<?php

namespace App\Http\Requests\TrackedStockRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrackedStockRequest extends FormRequest
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
            'stock_id' => 'required|int',
            'data' => 'required|array',
        ];
    }
}
