<h1 align="center">会员卡号管理</h1>

#### 根据会员ID查询会员卡号列表
```
请求方式：GET
请求地址：currency/admin-currency-bank-cards?q=1&page=1
请求参数：
    q 会员ID
    page 页码
返回值:
{
    "current_page": 1,
    "data": [
        {
            "id": 1, // 卡号ID
            "text": string // 开户名
        },
        ...
    ],
    "first_page_url": "http://*.*.*/currency/admin-currency-bank-cards?page=1",
    "from": null,
    "last_page": 1,
    "last_page_url": "http://*.*.*/currency/admin-currency-bank-cards?page=1",
    "next_page_url": null,
    "path": "http://*.*.*/currency/admin-currency-bank-cards",
    "per_page": 15,
    "prev_page_url": null,
    "to": null,
    "total": 0
}
```
#### 会员卡号列表
```
请求方式：GET
请求地址：/currency/bank-cards
返回值:
{
    "current_page": 1,
    "data": [
        {
            "id": $this->id, // 卡号ID
            "user_id": $this->user_id, // 所属会员ID
            "name": $this->name, // 开户名
            "bank": $this->bank, // 开户行
            "mobile": $this->mobile, // 预留手机号
            "account": $this->account, // 账号
            "created_at": '1秒前' // 添加时间
        },
        ...
    ],
    "first_page_url": "http://*.*.*/currency/bank-cards?page=1",
    "from": null,
    "last_page": 1,
    "last_page_url": "http://*.*.*/currency/bank-cards?page=1",
    "next_page_url": null,
    "path": "http://*.*.*/currency/bank-cards",
    "per_page": 15,
    "prev_page_url": null,
    "to": null,
    "total": 0
}
```
#### 会员卡添加
```
请求方式：POST
请求地址：/currency/bank-cards
返回值:
{
    "id": $this->id, // 卡号ID
    "user_id": $this->user_id, // 所属会员ID
    "name": $this->name, // 开户名
    "bank": $this->bank, // 开户行
    "mobile": $this->mobile, // 预留手机号
    "account": $this->account, // 账号
    "created_at": '1秒前' // 添加时间
}
```
#### 会员卡详细
```
请求方式：GET
请求地址：/currency/bank-cards/{id}
返回值:
{
    "id": $this->id, // 卡号ID
    "user_id": $this->user_id, // 所属会员ID
    "name": $this->name, // 开户名
    "bank": $this->bank, // 开户行
    "mobile": $this->mobile, // 预留手机号
    "account": $this->account, // 账号
    "created_at": '1秒前' // 添加时间
}
```
#### 会员卡修改
```
请求方式：PUT|PATCH
请求地址：/currency/bank-cards/{id}
请求参数：
{
    "name": $this->name, // 开户名
    "bank": $this->bank, // 开户行
    "mobile": $this->mobile, // 预留手机号
    "account": $this->account, // 账号
}
返回值:
{
    "status": "success",
    "message": "更新成功",
    "result": 
    {
        "id": $this->id, // 卡号ID
    }
}
```
#### 会员卡删除
```
请求方式：DELETE
请求地址：/currency/bank-cards/{id}
返回值:
{
    "status": "success",
    "message": "删除成功",
    "result": 
    {
        "id": $this->id, // 卡号ID
    }
}
```