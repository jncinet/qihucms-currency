<?php

namespace Qihucms\Currency\Resources\ExchangeOrder;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExchangeOrderCollection extends ResourceCollection
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
