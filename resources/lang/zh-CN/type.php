<?php

return [
    'id' => 'ID',
    'name' => '货币名称',
    'ico' => '小图标',
    'unit' => '单位',
    'recharge_rate' => '充值汇率',
    'cash_out_rate' => '提现汇率',
    'cash_out_service_rate' => '提现手续费比例',
    'recharge_min_amount' => '最小充值金额',
    'cash_out_max_amount' => '每日最高提现',
    'cash_out_min_amount' => '每笔最低提现',
    'cash_out_min_rate' => '单笔最低手续费',
    'cash_out_max_rate' => '单笔最高手续费',
    'recharge_status' => ['label' => '是否可以充值', 'value' => ['否', '是']],
    'exchange_status' => ['label' => '是否可以兑换', 'value' => ['否', '是']],
    'cash_out_status' => ['label' => '是否可以提现', 'value' => ['否', '是']],

    'recharge_rate_tip' => '1RMB=:rate',
    'cash_out_rate_tip' => ':rate=1RMB',
    'not_recharge' => '不支持充值',
    'not_cash' => '不支持提现',
    'service_free' => '无手续费',

    'recharge_rate_help' => '1RMB = ？，为零时不能充值',
    'cash_out_rate_help' => '？ = 1RMB，为零时不能提现，',
    'cash_out_service_rate_help' => '为零时不扣除手续费，提现一万扣除的手续费数额',
    'recharge_min_amount_help' => '此数额是RMB金额',
    'cash_out_amount_help' => '此数额是虚拟货币数，不是RMB金额',
    'cash_out_min_rate_help' => '此数额是RMB金额',
    'cash_out_max_rate_help' => '此数额是RMB金额',
];