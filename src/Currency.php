<?php

namespace Qihucms\Currency;

use Qihucms\Currency\Models\CurrencyBankCard;
use Qihucms\Currency\Models\CurrencyExchange;
use Qihucms\Currency\Models\CurrencyType;
use Qihucms\Currency\Models\CurrencyUser;
use Qihucms\Currency\Models\CurrencyUserLog;

class Currency
{
    /**
     * 获取用户所有货币信息
     *
     * @param int $user_id 会员ID
     * @return mixed
     */
    public static function getUserAccount($user_id)
    {
        return CurrencyUser::where('user_id', $user_id)->get();
    }

    /**
     * 读取用户某种货币的金额
     *
     * @param int $user_id 会员ID
     * @param int $type_id 货币类型ID
     * @return mixed
     */
    public static function findUserAccountByType($user_id, $type_id)
    {
        return CurrencyUser::firstOrCreate(['user_id' => $user_id, 'currency_type_id' => $type_id]);
    }

    /**
     * 入账
     *
     * @param int $user_id 会员ID
     * @param int $type_id 交易货币类型
     * @param float $amount 交易金额
     * @param string $trigger 触发事件
     * @param int $order_id 订单号
     * @param string $desc 备注
     * @return integer
     */
    public static function entry($user_id, $type_id, $amount, $trigger, $order_id = 0, $desc = '')
    {
        $account = self::findUserAccountByType($user_id, $type_id);
        if ($account) {
            // 更新账户余额
            $account->amount = bcadd($account->amount, $amount, 2);
            if ($account->save()) {
                // 记录流水
                if (self::log($account, $amount, $trigger, $order_id, $desc)) {
                    return 100;
                } else {
                    return 105;
                }
            } else {
                return 102;
            }
        } else {
            return 104;
        }
    }

    /**
     * 出账
     *
     * @param int $user_id 会员ID
     * @param int $type_id 交易货币类型
     * @param float $amount 交易金额
     * @param string $trigger 触发事件
     * @param int $order_id 订单号
     * @param string $desc 备注
     * @return integer
     */
    public static function expend($user_id, $type_id, $amount, $trigger, $order_id = 0, $desc = '')
    {
        $account = self::findUserAccountByType($user_id, $type_id);
        if ($account) {
            $subAmount = bcsub($account->amount, $amount, 2);
            if ($subAmount < 0) {
                return 101;
            }
            // 更新账户余额
            $account->amount = $subAmount;
            if ($account->save()) {
                // 记录流水
                if (self::log($account, $amount, $trigger, $order_id, $desc)) {
                    return 100;
                } else {
                    return 105;
                }
            } else {
                return 103;
            }
        } else {
            return 104;
        }
    }

    /**
     * 记录日志
     *
     * @param CurrencyUser $currencyUser 支付会员账户
     * @param float $amount 支付金额
     * @param string $trigger 触发事件
     * @param int $order_id 订单号
     * @param string $desc 备注
     * @return mixed
     */
    public static function log(CurrencyUser $currencyUser, $amount, $trigger, $order_id = 0, $desc = '')
    {
        return CurrencyUserLog::create([
            'user_id' => $currencyUser->user_id,
            'currency_type_id' => $currencyUser->currency_type_id,
            'trigger_event' => $trigger,
            'order_id' => $order_id,
            'amount' => $amount,
            'user_current_amount' => $currencyUser->amount,
            'desc' => $desc
        ]);
    }

    /**
     * 验证收款卡号是否属于会员
     *
     * @param int $user_id 会员ID
     * @param int $id 银行卡ID
     * @return mixed
     */
    public static function verifyUserBankCard($user_id, $id)
    {
        return CurrencyBankCard::where('user_id', $user_id)->where('id', $id)->exists();
    }

    /**
     * 货币详细
     *
     * @param int $id 货币ID
     * @return mixed
     */
    public static function type($id)
    {
        return CurrencyType::find($id);
    }

    /**
     * 所有的货币类型
     *
     * @param array $condition 条件
     * @return \Illuminate\Database\Eloquent\Collection|CurrencyType[]
     */
    public static function allType(array $condition = [])
    {
        if (count($condition)) {
            return CurrencyType::where($condition)->get();
        }

        return CurrencyType::all();
    }

    /**
     * 兑换详细
     *
     * @param int $id 兑换类型ID
     * @return mixed
     */
    public static function exchange($id)
    {
        return CurrencyExchange::find($id);
    }

    /**
     * 所有兑换详细
     *
     * @param array $condition 条件
     * @return \Illuminate\Database\Eloquent\Collection|CurrencyExchange[]
     */
    public static function allExchange(array $condition = [])
    {
        if (count($condition)) {
            return CurrencyExchange::where($condition)->get();
        }

        return CurrencyExchange::all();
    }

    /**
     * 计算服务费
     *
     * @param int $toAmount 交易金额
     * @param int $rate 汇率
     * @param float $min 最小服务费
     * @param float $max 最大服务费
     * @return float|int|mixed
     */
    public static function calculateServiceFee($toAmount = 0, $rate = 0, $min = 0.00, $max = 0.00)
    {
        $serviceFeeAmount = 0;

        if ($rate > 0 && $toAmount > 0) {
            // 手续费金额
            $serviceFeeAmount = bcmul($toAmount, $rate, 2);
            $serviceFeeAmount = bcdiv($serviceFeeAmount, 10000, 2);
            // 最高服务费取最低
            $serviceFeeAmount = $max == 0 ? $serviceFeeAmount : min($max, $serviceFeeAmount);
            // 最低服务费取最高
            $serviceFeeAmount = $min == 0 ? $serviceFeeAmount : max($min, $serviceFeeAmount);
        }

        return $serviceFeeAmount;
    }
}