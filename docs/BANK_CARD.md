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
            "text": '张三' // 开户名
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
            "id": 1, // 卡号ID
            "user_id": 666, // 所属会员ID
            "name": '张三', // 开户名
            "bank": '中国银行', // 开户行
            "mobile": '188000011*1', // 预留手机号
            "account": '65724324324324322346', // 账号
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
    "id": 1, // 卡号ID
    "user_id": 666, // 所属会员ID
    "name": '张三', // 开户名
    "bank": '中国银行', // 开户行
    "mobile": '188000011*1', // 预留手机号
    "account": '65724324324324322346', // 账号
    "created_at": '1秒前' // 添加时间
}
```
#### 会员卡详细
```
请求方式：GET
请求地址：/currency/bank-cards/{id}
返回值:
{
    "id": 1, // 卡号ID
    "user_id": 666, // 所属会员ID
    "name": '张三', // 开户名
    "bank": '中国银行', // 开户行
    "mobile": '188000011*1', // 预留手机号
    "account": '65724324324324322346', // 账号
    "created_at": '1秒前' // 添加时间
}
```
#### 会员卡修改
```
请求方式：PUT|PATCH
请求地址：/currency/bank-cards/{id}
请求参数：
{
    "name": '张三', // 开户名
    "bank": '中国银行', // 开户行
    "mobile": '188000011*1', // 预留手机号
    "account": '65724324324324322346', // 账号
}
返回值:
{
    "status": "success",
    "message": "更新成功",
    "result": 
    {
        "id": 1, // 卡号ID
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
        "id": 1, // 卡号ID
    }
}
```

## 数据库

### 会员收款卡号：currency_bank_cards
| Field             | Type      | Length    | AllowNull | Default   | Comment       |
| :----             | :----     | :----     | :----     | :----     | :----         |
| id                | bigint    |           |           |           |               |
| user_id           | bigint    |           |           |           | 会员ID         |
| name              | varchar   | 66        |           |           | 开户名         |
| bank              | varchar   | 255       |           |           | 开户行         |
| mobile            | char      | 11        | Y         | NULL      | 预留手机号      |
| account           | varchar   | 255       |           |           | 账号           |
| created_at        | timestamp |           | Y         | NULL      | 创建时间        |
| updated_at        | timestamp |           | Y         | NULL      | 更新时间        |