<?php

namespace Qihucms\Currency\Resources\ExchangeOrder;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Qihucms\Currency\Resources\Exchange\Exchange;

class ExchangeOrder extends JsonResource
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
            'currency_exchange' => new Exchange($this->currency_exchange),
            'rate' => $this->rate,
            'exchange_amount' => $this->exchange_amount,
            'recorded_amount' => $this->recorded_amount,
            'user_amount' => $this->user_amount,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
