<?php

namespace Qihucms\Currency\Resources\RechargeOrder;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RechargeOrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
