<h1 align="center">兑换订单</h1>

### 兑换订单列表
```
请求方式：GET
请求地址：/currency/exchange-orders
请求参数：
{
    "currency_exchange_id": 1 // 可选）兑换类型ID号
    "status": 1 // 可选）业务状态：[0=>'兑换中', 1=>'兑换成功', 2=>'兑换失败']
    "page": // 可选）分页页码
    "limit": // 可选）分页条数
}
返回值:
{
    "current_page": 1,
    "data": [
        {
            "id": 1, // 订单ID
            "user_id": 666, // 兑换会员ID
            "currency_exchange": {"id"： 1, "rate": "兑换汇率", ...}, // 兑换汇率详细
            "rate": 50, // 兑换汇率
            "exchange_amount": 100.00, // 兑换金额
            "recorded_amount": 50.00, // 到账金额
            "user_amount": 1.00, // 会员账户余额
            "status": 3, // 业务状态：[0=>'兑换中', 1=>'兑换成功', 2=>'兑换失败']
            "created_at": '1秒前' // 申请时间
        },
        ...
    ],
    "first_page_url": "http://*.*.*/currency/exchange-orders?page=1",
    "from": null,
    "last_page": 1,
    "last_page_url": "http://*.*.*/currency/exchange-orders?page=1",
    "next_page_url": null,
    "path": "http://*.*.*/currency/exchange-orders",
    "per_page": 15,
    "prev_page_url": null,
    "to": null,
    "total": 0
}
```

## 兑换
```
请求方式：POST
请求地址：/currency/exchange-orders
返回值:
{
    "id": 1, // 订单ID
    "user_id": 666, // 兑换会员ID
    "currency_exchange": {"id"： 1, "rate": "兑换汇率", ...}, // 兑换汇率详细
    "rate": 50, // 兑换汇率
    "exchange_amount": 100.00, // 兑换金额
    "recorded_amount": 50.00, // 到账金额
    "user_amount": 1.00, // 会员账户余额
    "status": 3, // 业务状态：[0=>'兑换中', 1=>'兑换成功', 2=>'兑换失败']
    "created_at": '1秒前' // 申请时间
}
```

### 兑换订单详细
```
请求方式：GET
请求地址：/currency/exchange-orders/{id}
返回值:
{
    "id": 1, // 订单ID
    "user_id": 666, // 兑换会员ID
    "currency_exchange": {"id"： 1, "rate": "兑换汇率", ...}, // 兑换汇率详细
    "rate": 50, // 兑换汇率
    "exchange_amount": 100.00, // 兑换金额
    "recorded_amount": 50.00, // 到账金额
    "user_amount": 1.00, // 会员账户余额
    "status": 3, // 业务状态：[0=>'兑换中', 1=>'兑换成功', 2=>'兑换失败']
    "created_at": '1秒前' // 申请时间
}
```

### 兑换订单删除（非无效订单不可删除）
```
请求方式：DELETE
请求地址：/currency/exchange-orders/{id}
返回值:
{
    "status": "success",
    "message": "删除成功",
    "result": 
    {
        "id": 1, // 订单ID
    }
}
```


## 数据库

### 兑换订单记录：currency_exchange_orders

| Field                 | Type      | Length    | AllowNull | Default   | Comment       |
| :----                 | :----     | :----     | :----     | :----     | :----         |
| id                    | bigint    |           |           |           |               |
| user_id               | bigint    |           |           |           | 兑换会员       |
| currency_exchange_id  | bigint    |           |           |           | 兑换类型       |
| rate                  | int       |           |           | 0         | 兑换汇率       |
| exchange_amount       | decimal   | 10, 2     |           | 0.00      | 兑换金额       |
| recorded_amount       | decimal   | 10, 2     |           | 0.00      | 到账金额       |
| user_amount           | decimal   | 10, 2     |           | 0.00      | 会员账户金额    |
| status                | tinyint   |           |           | 0         | 兑换状态       |
| created_at            | timestamp |           | Y         | NULL      | 创建时间       |
| updated_at            | timestamp |           | Y         | NULL      | 更新时间       |
