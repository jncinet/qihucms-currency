<h1 align="center">货币类型兑换</h1>

## 货币类型兑换列表
```
请求方式：GET
请求地址：/currency/exhanges
返回值:
[
    {
        'id' => $this->id, // 兑换ID
        'currency_type_id' => {"id"： 1, "name": "货币名称", ...}, // 兑换类型详细
        'currency_type_to' => {"id"： 1, "name": "货币名称", ...}, // 希望兑换类型详细
        'rate' => 50, // 兑换汇率
        'exchange_max_amount' => 10000.00, // 每日最大兑换数额
    },
    ...
]
```

## 货币类型兑换详细
```
请求方式：GET
请求地址：/currency/exhanges/{id}
返回值:
{
    'id' => $this->id, // 兑换ID
    'currency_type_id' => {"id"： 1, "name": "货币名称", ...}, // 兑换类型详细
    'currency_type_to' => {"id"： 1, "name": "货币名称", ...}, // 希望兑换类型详细
    'rate' => 50, // 兑换汇率
    'exchange_max_amount' => 10000.00, // 每日最大兑换数额
}
```