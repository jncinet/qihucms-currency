<h1 align="center">充值订单</h1>

### 充值订单列表
```
请求方式：GET
请求地址：/currency/recharge-orders
请求参数：
{
    "type": 1 // 可选）充值类型ID号
    "status": 1 // 可选）业务状态：[0=>'充值中', 1=>'充值成功', 2=>'充值失败']
    "page": // 可选）分页页码
    "limit": // 可选）分页条数
}
返回值:
{
    "current_page": 1,
    "data": [
        {
            "id": 1, // 订单ID
            "user_id": 666, // 充值会员ID
            "currency_type": {"id"： 1, "name": "货币名称", ...}, // 货币详细
            "rate": 50, // 充值汇率
            "recharge_amount": 100.00, // 充值金额
            "recorded_amount": 50.00, // 到账金额
            "user_amount": 1.00, // 会员账户余额
            "status": 3, // 业务状态：[0=>'充值中', 1=>'充值成功', 2=>'充值失败']
            "created_at": '1秒前' // 申请时间
        },
        ...
    ],
    "first_page_url": "http://*.*.*/currency/recharge-orders?page=1",
    "from": null,
    "last_page": 1,
    "last_page_url": "http://*.*.*/currency/recharge-orders?page=1",
    "next_page_url": null,
    "path": "http://*.*.*/currency/recharge-orders",
    "per_page": 15,
    "prev_page_url": null,
    "to": null,
    "total": 0
}
```

## 申请充值
```
请求方式：POST
请求地址：/currency/recharge-orders
返回值:
{
    "id": 1, // 订单ID
    "user_id": 666, // 充值会员ID
    "currency_type": {"id"： 1, "name": "货币名称", ...}, // 货币详细
    "rate": 50, // 充值汇率
    "recharge_amount": 100.00, // 充值金额
    "recorded_amount": 50.00, // 到账金额
    "user_amount": 1.00, // 会员账户余额
    "status": 3, // 业务状态：[0=>'充值中', 1=>'充值成功', 2=>'充值失败']
    "created_at": '1秒前' // 申请时间
}
```

### 充值订单详细
```
请求方式：GET
请求地址：/currency/recharge-orders/{id}
返回值:
{
    "id": 1, // 订单ID
    "user_id": 666, // 充值会员ID
    "currency_type": {"id"： 1, "name": "货币名称", ...}, // 货币详细
    "rate": 50, // 充值汇率
    "recharge_amount": 100.00, // 充值金额
    "recorded_amount": 50.00, // 到账金额
    "user_amount": 1.00, // 会员账户余额
    "status": 3, // 业务状态：[0=>'充值中', 1=>'充值成功', 2=>'充值失败']
    "created_at": '1秒前' // 申请时间
}
```

### 充值订单更新
// 待完成

### 充值订单删除（非无效订单不可删除）
```
请求方式：DELETE
请求地址：/currency/recharge-orders/{id}
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

### 充值订单记录：currency_recharge_orders

| Field                 | Type      | Length    | AllowNull | Default   | Comment       |
| :----                 | :----     | :----     | :----     | :----     | :----         |
| id                    | bigint    |           |           |           |               |
| user_id               | bigint    |           |           |           | 充值会员       |
| currency_type_id      | bigint    |           |           |           | 充值类型       |
| rate                  | int       |           |           | 0         | 充值汇率       |
| recharge_amount       | decimal   | 10, 2     |           | 0.00      | 充值金额       |
| recorded_amount       | decimal   | 10, 2     |           | 0.00      | 到账金额       |
| user_amount           | decimal   | 10, 2     |           | 0.00      | 会员账户金额    |
| status                | tinyint   |           |           | 0         | 充值状态       |
| created_at            | timestamp |           | Y         | NULL      | 创建时间       |
| updated_at            | timestamp |           | Y         | NULL      | 更新时间       |
