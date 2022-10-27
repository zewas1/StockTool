<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static whereId(int $id)
 * @method static where(string $field, string $string, string $value)
 * @method static findOrFail(int $id)
 * @property mixed $change_value
 * @property mixed $change_percent
 * @property mixed $company_name
 * @property mixed $currency
 * @property mixed $latest_price
 * @property mixed $symbol
 * @property mixed $year_high
 * @property mixed $year_low
 * @property mixed $ytd_change
 * @property mixed $is_us_market_open
 */
class Stock extends Model
{

}
