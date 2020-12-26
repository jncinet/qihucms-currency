<?php

namespace Qihucms\Currency\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Qihucms\Currency\Currency;
use Qihucms\Currency\Resources\User\UserCollection;
use Qihucms\Currency\Resources\User\User as UserResource;

class UserController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * 所有账户信息
     *
     * @return UserCollection
     */
    public function index()
    {
        $result = Currency::getUserAccount(\Auth::id());

        return new UserCollection($result);
    }

    /**
     * 类型账户
     *
     * @param $id
     * @return UserResource
     */
    public function show($id)
    {
        $result = Currency::findUserAccountByType(\Auth::id(), $id);

        return new UserResource($result);
    }
}