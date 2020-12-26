<?php

namespace Qihucms\Currency\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyBankCard extends Model
{
    protected $fillable = [
        'user_id', 'name', 'bank', 'mobile', 'account'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}