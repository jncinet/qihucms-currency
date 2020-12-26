<?php

namespace Qihucms\Currency\Resources\RechargeOrder;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Qihucms\Currency\Resources\Type\Type;

class RechargeOrder extends JsonResource
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
            'rate' => $this->rate,
            'recharge_amount' => $this->recharge_amount,
            'recorded_amount' => $this->recorded_amount,
            'user_amount' => $this->user_amount,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
