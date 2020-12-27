<h1 align="center">会员账户</h1>

## 会员账户所有货币账户
```
请求方式：GET
请求地址：/currency/users
返回值:
[
    {
        'id' => $this->id,
        'user_id' => 1, // 会员ID
        'currency_type' => {"id"： 1, "name": "货币名称", ...}, // 货币类型详细
        'amount' => 50, // 账户余额
        'updated_at' => '1秒前', // 账户最后更新时间
    },
    ...
]
```

## 会员账户详细
```
请求方式：GET
请求地址：/currency/users/{id=货币类型ID}
返回值:
{
    'id' => $this->id,
    'user_id' => 1, // 会员ID
    'currency_type' => {"id"： 1, "name": "货币名称", ...}, // 货币类型详细
    'amount' => 50, // 账户余额
    'updated_at' => '1秒前', // 账户最后更新时间
}
```