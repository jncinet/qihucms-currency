<?php

namespace Qihucms\Currency\Repositories;

use Qihucms\Currency\Models\CurrencyUserLog;

class UserLogRepository
{
    protected $log;

    public function __construct(CurrencyUserLog $log)
    {
        $this->log = $log;
    }

    /**
     * 获取流水记录
     *
     * @param array $condition
     * @param int $limit
     * @return mixed
     */
    public function logPaginate(array $condition, int $limit = 15)
    {
        return $this->log->where($condition)->orderBy('id', 'desc')->paginate($limit);
    }

    /**
     * 流水详细
     *
     * @param $user_id
     * @param $id
     * @return mixed
     */
    public function findLogByIdAndUserId($user_id, $id)
    {
        return $this->log->where('id', $id)->where('user_id', $user_id)->first($id);
    }
}