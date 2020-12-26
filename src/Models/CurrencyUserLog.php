<?php

namespace Qihucms\Currency\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyUserLog extends Model
{
    protected $fillable = [
        'user_id', 'currency_type_id', 'trigger_event', 'order_id', 'amount', 'user_current_amount', 'desc'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'user_current_amount' => 'decimal:2',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return BelongsTo
     */
    public function currency_type(): BelongsTo
    {
        return $this->belongsTo('Qihucms\Currency\Models\CurrencyType');
    }
}