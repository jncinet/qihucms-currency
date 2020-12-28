<?php

namespace Qihucms\Currency\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Qihucms\Currency\Currency;
use Qihucms\Currency\Resources\Exchange\ExchangeCollection;
use Qihucms\Currency\Resources\Exchange\Exchange as ExchangeResource;

class ExchangeController extends Controller
{
    /**
     * 所有兑换规则
     *
     * @return ExchangeCollection
     */
    public function index()
    {
        $result = Currency::allExchange();

        return new ExchangeCollection($result);
    }

    /**
     * 兑换规则
     *
     * @param $id
     * @return ExchangeResource|JsonResponse
     */
    public function show($id)
    {
        $result = Currency::exchange($id);

        if ($result) {
            return new ExchangeResource($result);
        }

        return $this->jsonResponse([__('currency::message.record_does_not_exist')], '', 422);
    }
}