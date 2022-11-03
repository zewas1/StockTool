<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserOwnedStock extends Model
{
    protected $fillable = [
        'tracked_stock_id',
        'user_id',
        'quantity',
        'created_at',
        'updated_at'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function trackedStock(): BelongsTo
    {
        return $this->belongsTo(TrackedStock::class, 'tracked_stock_id');
    }
}
