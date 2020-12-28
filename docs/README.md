<h1 align="center">站内支付货币管理</h1>

## 安装
```shell
composer require jncinet/qihucms-currency
```

## 开始
### 数据迁移
```shell
$ php artisan migrate
```
### 发布资源
```shell
$ php artisan vendor:publish --provider="Qihucms\Currency\CurrencyServiceProvider"
```

## 配置
> 接口URL前缀可在文件/config/qihu.php中设置 currency_prefix 配置；

## 后台
+ 货币类型 => currency/types
+ 货币兑换类型 => currency/exchanges
+ 会员卡号 => currency/bank-cards
+ 会员账户 => currency/users
+ 账户流水 => currency/user-logs
+ 充值订单 => currency/recharge-orders
+ 兑换订单 => currency/exchange-orders
+ 提现订单 => currency/cash-out-orders

## 使用
[会员卡号](https://jncinet.github.io/qihucms-currency/BANK_CARD)  
[会员账户](https://jncinet.github.io/qihucms-currency/USER)  
[账户流水](https://jncinet.github.io/qihucms-currency/USER_LOG)  

[提现订单](https://jncinet.github.io/qihucms-currency/CASH_OUT_ORDER)  
[充值订单](https://jncinet.github.io/qihucms-currency/RECHARGE_ORDER)  
[兑换订单](https://jncinet.github.io/qihucms-currency/EXCHANGE_ORDER)  

[货币类型](https://jncinet.github.io/qihucms-currency/TYPE)  
[货币类型相互兑换](https://jncinet.github.io/qihucms-currency/EXCHANGE)  