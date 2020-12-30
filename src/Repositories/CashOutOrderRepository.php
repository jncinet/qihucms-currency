<?php

namespace Qihucms\Currency\Repositories;

use Illuminate\Support\Facades\Log;
use Qihucms\Currency\Currency;
use Qihucms\Currency\Models\CurrencyCashOutOrder;

class CashOutOrderRepository
{
    protected $order;

    public function __construct(CurrencyCashOutOrder $order)
    {
        $this->order = $order;
    }

    /**
     * 读取会员提现记录
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
     * 申请提现
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->order->create($data);
    }

    /**
     * 读取会员提现记录详细
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
     * 删除记录
     *
     * @param $user_id
     * @param $id
     * @return mixed
     */
    public function deleteByUserIdAndId($user_id, $id)
    {
        // =0时，系统已扣除会员余额，不能删除
        return $this->order->where('user_id', $user_id)->where('id', $id)->where('status', '>', 0)->delete();
    }

    /**
     * 统计当天会员总提现数额
     *
     * @param $user_id
     * @param $type_id
     * @return mixed
     */
    public function sumUserTodayCashOutAmount($user_id, $type_id)
    {
        return $this->order->where('user_id', $user_id)
            ->where('status', 1)
            ->where('current_type_id', $type_id)
            ->sum('cash_out_amount');
    }

    /**
     * 取消订单后退还额度
     *
     * @param $user_id
     * @param $id
     * @return bool
     */
    public function cancelCashOutOrder($user_id, $id)
    {
        $order = $this->order->where('user_id', $user_id)->where('id', $id)->where('status', '=', 0)->first();
        if ($order) {
            $result = Currency::entry(
                $order->user_id,
                $order->currency_type_id,
                $order->cash_out_amount,
                'cash-out-order-cancel',
                $order->id,
                '提现失败退还额度'
            );
            if ($result === 100) {
                $order->status = 2;
                $order->save();
                return true;
            }
            Log::alert('提现订单取消退还额度失败', ['user_id' => $user_id, 'order_id' => $id]);
        }
        return false;
    }
}