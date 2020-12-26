<h1 align="center">站内支付货币管理</h1>

## 安装
```shell
composer require jncinet/qihucms-currency
```
## 使用
> 接口URL前缀可在文件/config/qihu.php中设置 currency_prefix 配置
### 会员卡号管理
#### 根据会员ID查询会员卡号列表
```
请求方式：GET
请求地址：/admin-currency-bank-cards?q=1&page=1
请求参数：
    q 会员ID
    page 页码
返回值:
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "text": string
        },
        ...
    ],
    "first_page_url": "http://api.v2.name/currency/admin-currency-bank-cards?page=1",
    "from": null,
    "last_page": 1,
    "last_page_url": "http://api.v2.name/currency/admin-currency-bank-cards?page=1",
    "next_page_url": null,
    "path": "http://api.v2.name/currency/admin-currency-bank-cards",
    "per_page": 15,
    "prev_page_url": null,
    "to": null,
    "total": 0
}
```
#### 会员卡号列表
```
请求方式：GET
请求地址：/bank-cards
返回值:
{
    "current_page": 1,
    "data": [
        {
            "id": $this->id,
            "user_id": $this->user_id,
            "name": $this->name,
            "bank": $this->bank,
            "mobile": $this->mobile,
            "account": $this->account,
            "created_at": '1秒前'
        },
        ...
    ],
    "first_page_url": "http://api.v2.name/currency/bank-cards?page=1",
    "from": null,
    "last_page": 1,
    "last_page_url": "http://api.v2.name/currency/bank-cards?page=1",
    "next_page_url": null,
    "path": "http://api.v2.name/currency/bank-cards",
    "per_page": 15,
    "prev_page_url": null,
    "to": null,
    "total": 0
}


```