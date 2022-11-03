<?php

declare(strict_types=1);

namespace App\Http\Requests\TrackedStockRequests;

use Illuminate\Foundation\Http\FormRequest;

class ListTrackedStockRequest extends FormRequest
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
            'show_one_user' => 'required|bool',
        ];
    }
}
