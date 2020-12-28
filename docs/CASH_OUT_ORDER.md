<h1 align="center">提现订单</h1>

### 提现订单列表
```
请求方式：GET
请求地址：/currency/cash-out-orders
请求参数：
{
    "type": 1 // 可选）提现类型ID号
    "bank_card": '6453288432' // 可选）收款账号
    "status": 1 // 可选）业务状态：[0=>'申请中', 1=>'已审核', 2=>'未通过', 3=>'已打款']
    "page": // 可选）分页页码
    "limit": // 可选）分页条数
}
返回值:
{
    "current_page": 1,
    "data": [
        {
            "id": 1, // 订单ID
            "user_id": 666, // 提现会员ID
            "currency_type": {"id"： 1, "name": "货币名称", ...}, // 货币详细
            "currency_bank_card": {"id": 1, "bank": "开户行", ...}, // 收款账号详细
            "rate": 50, // 提现汇率
            "cash_out_amount": 100.00, // 提现金额
            "recorded_amount": 50.00, // 到账金额
            "user_amount": 1.00, // 会员账户余额
            "status": 3, // 业务状态：[0=>'申请中', 1=>'已审核', 2=>'未通过', 3=>'已打款']
            "created_at": '1秒前' // 申请时间
        },
        ...
    ],
    "first_page_url": "http://*.*.*/currency/cash-out-orders?page=1",
    "from": null,
    "last_page": 1,
    "last_page_url": "http://*.*.*/currency/cash-out-orders?page=1",
    "next_page_url": null,
    "path": "http://*.*.*/currency/cash-out-orders",
    "per_page": 15,
    "prev_page_url": null,
    "to": null,
    "total": 0
}
```

## 申请提现
```
请求方式：POST
请求地址：/currency/cash-out-orders
返回值:
{
    "id": 1, // 订单ID
    "user_id": 666, // 提现会员ID
    "currency_type": {"id"： 1, "name": "货币名称", ...}, // 货币详细
    "currency_bank_card": {"id": 1, "bank": "开户行", ...}, // 收款账号详细
    "rate": 50, // 提现汇率
    "cash_out_amount": 100.00, // 提现金额
    "recorded_amount": 50.00, // 到账金额
    "user_amount": 1.00, // 会员账户余额
    "status": 3, // 业务状态：[0=>'申请中', 1=>'已审核', 2=>'未通过', 3=>'已打款']
    "created_at": '1秒前' // 申请时间
}
```

### 提现订单详细
```
请求方式：GET
请求地址：/currency/cash-out-orders/{id}
返回值:
{
    "id": 1, // 订单ID
    "user_id": 666, // 提现会员ID
    "currency_type": {"id"： 1, "name": "货币名称", ...}, // 货币详细
    "currency_bank_card": {"id": 1, "bank": "开户行", ...}, // 收款账号详细
    "rate": 50, // 提现汇率
    "cash_out_amount": 100.00, // 提现金额
    "recorded_amount": 50.00, // 到账金额
    "user_amount": 1.00, // 会员账户余额
    "status": 3, // 业务状态：[0=>'申请中', 1=>'已审核', 2=>'未通过', 3=>'已打款']
    "created_at": '1秒前' // 申请时间
}
```

### 提现订单删除（非无效订单不可删除）
```
请求方式：DELETE
请求地址：/currency/cash-out-orders/{id}
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

### 提现订单记录：currency_cash_out_orders

| Field                 | Type      | Length    | AllowNull | Default   | Comment       |
| :----                 | :----     | :----     | :----     | :----     | :----         |
| id                    | bigint    |           |           |           |               |
| user_id               | bigint    |           |           |           | 提现会员       |
| currency_type_id      | bigint    |           |           |           | 提现类型       |
| currency_bank_card_id | bigint    |           |           |           | 收款账号       |
| rate                  | int       |           |           | 0         | 提现汇率       |
| cash_out_amount       | decimal   | 10, 2     |           | 0.00      | 提现金额       |
| recorded_amount       | decimal   | 10, 2     |           | 0.00      | 到账金额       |
| user_amount           | decimal   | 10, 2     |           | 0.00      | 会员账户金额    |
| status                | tinyint   |           |           | 0         | 提现状态       |
| created_at            | timestamp |           | Y         | NULL      | 创建时间       |
| updated_at            | timestamp |           | Y         | NULL      | 更新时间       |
