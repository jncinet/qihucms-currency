<?php

namespace Qihucms\Currency\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyUser extends Model
{
    protected $fillable = [
        'user_id', 'currency_type_id', 'amount'
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