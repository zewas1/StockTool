<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static whereId(int $id)
 * @method static find(int $id)
 * @property mixed $user_id
 */
class TrackedStock extends Model
{
    protected $fillable = [
        'user_id',
        'stock_name',
        'stock_symbol',
        'is_tracking_enabled',
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
