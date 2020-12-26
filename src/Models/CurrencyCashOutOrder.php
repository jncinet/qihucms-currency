<?php

namespace Qihucms\Currency\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyCashOutOrder extends Model
{
    protected $fillable = [
        'user_id', 'currency_type_id', 'currency_bank_card_id', 'rate',
        'cash_out_amount', 'recorded_amount', 'user_amount', 'status'
    ];

    protected $casts = [
        'rate' => 'integer',
        'cash_out_amount' => 'decimal:2',
        'recorded_amount' => 'decimal:2',
        'user_amount' => 'decimal:2',
        'status' => 'integer'
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
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return BelongsTo
     */
    public function currency_bank_card(): BelongsTo
    {
        return $this->belongsTo('Qihucms\Currency\Models\CurrencyBankCard');
    }
}