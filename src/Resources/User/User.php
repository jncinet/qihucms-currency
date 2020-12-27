<?php

namespace Qihucms\Currency\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Qihucms\Currency\Resources\Type\Type;

class User extends JsonResource
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
            'amount' => $this->amount,
            'updated_at' => Carbon::parse($this->updated_at)->diffForHumans()
        ];
    }
}
