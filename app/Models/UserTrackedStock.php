<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $data)
 * @method static whereId(int $id)
 * @method static find(int $id)
 */
class UserTrackedStock extends Model
{
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
