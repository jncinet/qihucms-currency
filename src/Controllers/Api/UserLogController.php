<?php

namespace Qihucms\Currency\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Qihucms\Currency\Repositories\UserLogRepository;
use Qihucms\Currency\Resources\UserLog\UserLogCollection;
use Qihucms\Currency\Resources\UserLog\UserLog as UserLogResource;

class UserLogController extends Controller
{
    protected $log;

    public function __construct(UserLogRepository $log)
    {
        $this->middleware('auth:api');
        $this->log = $log;
    }

    /**
     * 会员所有流水记录
     *
     * @param Request $request
     * @return UserLogCollection
     */
    public function index(Request $request)
    {
        $condition = [
            ['user_id', '=', \Auth::id()]
        ];

        // 货币类型
        $type = (int)$request->get('type');
        if ($type) {
            $condition[] = ['currency_type_id', '=', $type];
        }

        // 触发事件
        $trigger = $request->get('trigger');
        if ($trigger) {
            $condition[] = ['trigger_event', '=', $trigger];
        }

        // 每页条数
        $limit = (int)$request->get('limit', 15);

        $result = $this->log->logPaginate($condition, $limit);

        return new UserLogCollection($result);
    }

    /**
     * 流水详细介绍
     *
     * @param $id
     * @return UserLogResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->log->findLogByIdAndUserId(\Auth::id(), $id);
        if ($result) {
            return new UserLogResource($result);
        }

        return $this->jsonResponse([__('currency::message.record_does_not_exist')], '', 422);
    }
}