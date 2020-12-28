<h1 align="center">账户日志</h1>

### 账户日志列表
```
请求方式：GET
请求地址：/currency/log-orders
请求参数：
{
    "type": 1 // 可选）货币类型ID号
    "trigger": 'recharge' // 可选）触发事件
    "page": // 可选）分页页码
    "limit": // 可选）分页条数
}
返回值:
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "user_id": 666, // 交易会员
            "currency_type": {"id"： 1, "name": "货币名称", ...}, // 货币详细
            "trigger_event": 'recharge', // 触发事件
            "order_id": 160', // 订单号
            "amount": 100.00, // 交易数额
            "user_current_amount": 50.00, // 当前会员账户金额
            "desc": '备注', // 备注
            "created_at": '1秒前' // 操作时间
        },
        ...
    ],
    "first_page_url": "http://*.*.*/currency/log-orders?page=1",
    "from": null,
    "last_page": 1,
    "last_page_url": "http://*.*.*/currency/log-orders?page=1",
    "next_page_url": null,
    "path": "http://*.*.*/currency/log-orders",
    "per_page": 15,
    "prev_page_url": null,
    "to": null,
    "total": 0
}
```

### 账户日志详细
```
请求方式：GET
请求地址：/currency/log-orders/{id}
返回值:
{
    "id": 1,
    "user_id": 666, // 交易会员
    "currency_type": {"id"： 1, "name": "货币名称", ...}, // 货币详细
    "trigger_event": 'recharge', // 触发事件
    "order_id": 160', // 订单号
    "amount": 100.00, // 交易数额
    "user_current_amount": 50.00, // 当前会员账户金额
    "desc": '备注', // 备注
    "created_at": '1秒前' // 操作时间
}
```

## 数据库

### 账户流水：currency_user_logs

| Field                 | Type      | Length    | AllowNull | Default   | Comment       |
| :----                 | :----     | :----     | :----     | :----     | :----         |
| id                    | bigint    |           |           |           |               |
| user_id               | bigint    |           |           |           | 交易会员       |
| currency_type_id      | bigint    |           |           |           | 货币类型       |
| trigger_event         | varchar   | 255       |           |           | 触发事件       |
| order_id              | varchar   | 255       |           |           | 订单号         |
| amount                | decimal   | 10, 2     |           |           | 交易数额       |
| user_current_amount   | decimal   | 10, 2     |           |           | 账户余额        |
| desc                  | varchar   | 255       | Y         | NULL      | 备注           |
| created_at            | timestamp |           | Y         | NULL      | 创建时间        |
| updated_at            | timestamp |           | Y         | NULL      | 更新时间        |
