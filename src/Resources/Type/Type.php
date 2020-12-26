<?php

namespace Qihucms\Currency\Resources\Type;

use Illuminate\Http\Resources\Json\JsonResource;

class Type extends JsonResource
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
            'name' => $this->name,
            'ico' => !empty($this->ico) ? \Storage::url($this->ico) : null,
            'unit' => $this->unit,
            'recharge_rate' => $this->recharge_rate,
            'cash_out_rate' => $this->cash_out_rate,
            'cash_out_service_rate' => $this->cash_out_service_rate,
            'recharge_min_amount' => $this->recharge_min_amount,
            'cash_out_max_amount' => $this->cash_out_max_amount,
            'cash_out_min_amount' => $this->cash_out_min_amount,
            'cash_out_min_rate' => $this->cash_out_min_rate,
            'cash_out_max_rate' => $this->cash_out_max_rate,
            'recharge_status' => $this->recharge_status,
            'exchange_status' => $this->exchange_status,
            'cash_out_status' => $this->cash_out_status,
        ];
    }
}
