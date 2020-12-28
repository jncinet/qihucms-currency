<?php

namespace Qihucms\Currency\Controllers\Api;

use App\Http\Controllers\Controller;
use Qihucms\Currency\Currency;
use Qihucms\Currency\Resources\Type\TypeCollection;
use Qihucms\Currency\Resources\Type\Type as TypeResource;

class TypeController extends Controller
{
    /**
     * 查询所有货币类型
     *
     * @return TypeCollection
     */
    public function index()
    {
        $result = Currency::allType();

        return new TypeCollection($result);
    }

    /**
     * 货币类型详细
     *
     * @param $id
     * @return TypeResource
     */
    public function show($id)
    {
        $result = Currency::type($id);

        return new TypeResource($result);
    }
}