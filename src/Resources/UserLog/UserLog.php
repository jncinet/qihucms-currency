<?php

namespace Qihucms\Currency\Resources\UserLog;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Qihucms\Currency\Resources\Type\Type;

class UserLog extends JsonResource
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
            'trigger_event' => $this->trigger_event,
            'order_id' => $this->order_id,
            'amount' => $this->amount,
            'user_current_amount' => $this->user_current_amount,
            'desc' => $this->desc,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
