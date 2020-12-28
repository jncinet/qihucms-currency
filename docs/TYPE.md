<h1 align="center">货币类型</h1>

## 货币类型列表
```
请求方式：GET
请求地址：/currency/types
返回值:
[
    {
        "id": 1, // 货币ID
        "name": '元宝', // 货币名称
        "ico": 'http://*.*.*/storage/currency/yb.jpg', // 小图标
        "unit": '个', // 单位
        "recharge_rate": 50, // 充值汇率
        "cash_out_rate": 60, // 提现汇率
        "cash_out_service_rate": 70, // 提现手续费比例
        "recharge_min_amount": 100.00, // 最小充值金额
        "cash_out_max_amount": 1000.00, // 每日最高提现
        "cash_out_min_amount": 10.00 // 每笔最低提现
        "cash_out_min_rate": 0.10 // 单笔最低手续费
        "cash_out_max_rate": 50.00 // 单笔最高手续费
        "recharge_status": 1 // 是否可以充值 [0 => '否', 1 => '是']
        "exchange_status": 0 // 是否可以兑换 [0 => '否', 1 => '是']
        "cash_out_status": 1 // 是否可以提现 [0 => '否', 1 => '是']
    },
    ...
]
```

## 货币类型详细
```
请求方式：GET
请求地址：/currency/types/{id}
返回值:
{
    "id": 1, // 货币ID
    "name": '元宝', // 货币名称
    "ico": 'http://*.*.*/storage/currency/yb.jpg', // 小图标
    "unit": '个', // 单位
    "recharge_rate": 50, // 充值汇率
    "cash_out_rate": 60, // 提现汇率
    "cash_out_service_rate": 70, // 提现手续费比例
    "recharge_min_amount": 100.00, // 最小充值金额
    "cash_out_max_amount": 1000.00, // 每日最高提现
    "cash_out_min_amount": 10.00 // 每笔最低提现
    "cash_out_min_rate": 0.10 // 单笔最低手续费
    "cash_out_max_rate": 50.00 // 单笔最高手续费
    "recharge_status": 1 // 是否可以充值 [0 => '否', 1 => '是']
    "exchange_status": 0 // 是否可以兑换 [0 => '否', 1 => '是']
    "cash_out_status": 1 // 是否可以提现 [0 => '否', 1 => '是']
}
```

## 数据库

### 会员账户：currency_types

| Field                 | Type      | Length    | AllowNull | Default   | Comment       |
| :----                 | :----     | :----     | :----     | :----     | :----         |
| id                    | bigint    |           |           |           |               |
| name                  | varchar   | 100       |           |           | 货币名称       |
| ico                   | varchar   | 100       |           |           | 小图标         |
| unit                  | varchar   | 10        |           |           | 单位          |
| recharge_rate         | int       |           |           | 0         | 1RMB=？       |
| cash_out_rate         | int       |           |           | 0         | ？=1RMB       |
| cash_out_service_rate | int       |           |           | 0         | 提现手续费比例  |
| recharge_min_amount   | decimal   | 10, 2     |           | 0.00      | 最小充值金额    |
| cash_out_max_amount   | decimal   | 10, 2     |           | 0.00      | 每日最高提现    |
| cash_out_min_amount   | decimal   | 10, 2     |           | 0.00      | 每笔最低提现    |
| cash_out_min_rate     | decimal   | 10, 2     |           | 0.00      | 单笔最低手续费  |
| cash_out_max_rate     | decimal   | 10, 2     |           | 0.00      | 单笔最高手续费  |
| recharge_status       | tinyint   | 1         |           | 0         | 是否可以充值    |
| exchange_status       | tinyint   | 1         |           | 0         | 是否可以兑换    |
| cash_out_status       | tinyint   | 1         |           | 0         | 是否可以提现    |
| created_at            | timestamp |           | Y         | NULL      | 创建时间       |
| updated_at            | timestamp |           | Y         | NULL      | 更新时间       |
