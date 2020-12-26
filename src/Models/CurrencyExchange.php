<?php

namespace Qihucms\Currency\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyExchange extends Model
{
    protected $fillable = [
        'currency_type_id', 'currency_type_to_id', 'rate', 'exchange_max_amount'
    ];

    protected $casts = [
        'rate' => 'integer',
        'exchange_max_amount' => 'decimal:2'
    ];

    /**
     * @return BelongsTo
     */
    public function currency_type(): BelongsTo
    {
        return $this->belongsTo('Qihucms\Currency\Models\CurrencyType');
    }

    /**
     * @return BelongsTo
     */
    public function currency_type_to(): BelongsTo
    {
        return $this->belongsTo('Qihucms\Currency\Models\CurrencyType');
    }
}