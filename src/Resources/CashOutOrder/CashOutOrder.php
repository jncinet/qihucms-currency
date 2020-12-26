<?php

namespace Qihucms\Currency\Resources\CashOutOrder;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Qihucms\Currency\Resources\BankCard\BankCard;
use Qihucms\Currency\Resources\Type\Type;

class CashOutOrder extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'currency_type' => new Type($this->currency_type),
            'currency_bank_card' => new BankCard($this->currency_bank_card),
            'rate' => $this->rate,
            'cash_out_amount' => $this->cash_out_amount,
            'recorded_amount' => $this->recorded_amount,
            'user_amount' => $this->user_amount,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
