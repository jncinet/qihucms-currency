<?php

namespace Qihucms\Currency\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyExchangeOrder extends Model
{
    protected $fillable = [
        'user_id', 'currency_exchange_id', 'rate', 'exchange_amount', 'recorded_amount', 'user_amount', 'status'
    ];

    protected $casts = [
        'rate' => 'integer',
        'exchange_amount' => 'decimal:2',
        'recorded_amount' => 'decimal:2',
        'user_amount' => 'decimal:2',
        'status' => 'integer'
    ];

    /**
     * @return BelongsTo
     */
    public function currency_exchange(): BelongsTo
    {
        return $this->belongsTo('Qihucms\Currency\Models\CurrencyExchange');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}