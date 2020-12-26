<?php

namespace Qihucms\Currency\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyType extends Model
{
    protected $fillable = [
        'name', 'ico', 'unit', 'recharge_rate', 'cash_out_rate', 'recharge_min_amount',
        'cash_out_max_amount', 'cash_out_min_amount', 'cash_out_min_rate', 'cash_out_max_rate',
        'recharge_status', 'exchange_status', 'cash_out_status', 'cash_out_service_rate'
    ];

    protected $casts = [
        'recharge_rate' => 'integer',
        'cash_out_rate' => 'integer',
        'cash_out_service_rate' => 'integer',
        'recharge_min_amount' => 'decimal:2',
        'cash_out_max_amount' => 'decimal:2',
        'cash_out_min_amount' => 'decimal:2',
        'cash_out_min_rate' => 'decimal:2',
        'cash_out_max_rate' => 'decimal:2',
        'recharge_status' => 'integer',
        'exchange_status' => 'integer',
        'cash_out_status' => 'integer',
    ];
}