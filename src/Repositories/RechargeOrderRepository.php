<?php

namespace Qihucms\Currency\Repositories;

use Qihucms\Currency\Models\CurrencyRechargeOrder;

class RechargeOrderRepository
{
    protected $order;

    public function __construct(CurrencyRechargeOrder $order)
    {
        $this->order = $order;
    }

    /**
     * 读取会员充值记录
     *
     * @param array $condition
     * @param int $limit
     * @return mixed
     */
    public function userOrderPaginate(array $condition = [], int $limit = 15)
    {
        return $this->order->where($condition)->orderBy('id', 'desc')->paginate($limit);
    }

    /**
     * 创建订单
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->order->create($data);
    }

    /**
     * 读取充值详细
     *
     * @param $user_id
     * @param $id
     * @return mixed
     */
    public function findByUserIdAndId($user_id, $id)
    {
        return $this->order->where('user_id', $user_id)->where('id', $id)->first();
    }

    /**
     * 删除充值订单
     *
     * @param $user_id
     * @param $id
     * @return mixed
     */
    public function deleteByUserIdAndId($user_id, $id)
    {
        return $this->order->where('user_id', $user_id)->where('id', $id)->delete();
    }
}