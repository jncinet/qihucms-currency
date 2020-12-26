<?php

namespace Qihucms\Currency\Repositories;

use Qihucms\Currency\Models\CurrencyExchangeOrder;

class ExchangeOrderRepository
{
    protected $order;

    public function __construct(CurrencyExchangeOrder $order)
    {
        $this->order = $order;
    }

    /**
     * 读取会员兑换记录
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
     * 读取会员兑换记录详细
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
     * 删除兑换订单
     *
     * @param $user_id
     * @param $id
     * @return mixed
     */
    public function deleteByUserIdAndId($user_id, $id)
    {
        return $this->order->where('user_id', $user_id)->where('id', $id)->delete();
    }

    /**
     * 统计当天会员总兑换数额
     *
     * @param $user_id
     * @param $exchange_id
     * @return mixed
     */
    public function sumUserTodayExchangeAmount($user_id, $exchange_id)
    {
        return $this->order->where('user_id', $user_id)
            ->where('status', 1)
            ->where('currency_exchange_id', $exchange_id)
            ->sum('exchange_amount');
    }
}