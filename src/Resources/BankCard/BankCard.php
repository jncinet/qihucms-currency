<?php

namespace Qihucms\Currency\Resources\BankCard;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BankCard extends JsonResource
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
            'name' => $this->name,
            'bank' => $this->bank,
            'mobile' => $this->mobile,
            'account' => $this->account,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
