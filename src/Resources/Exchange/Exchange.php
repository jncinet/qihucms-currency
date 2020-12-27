<?php

namespace Qihucms\Currency\Resources\Exchange;

use Illuminate\Http\Resources\Json\JsonResource;
use Qihucms\Currency\Resources\Type\Type;

class Exchange extends JsonResource
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
            'currency_type_id' => new Type($this->currency_type),
            'currency_type_to' => new Type($this->currency_type_to),
            'rate' => $this->rate,
            'exchange_max_amount' => $this->exchange_max_amount
        ];
    }
}
