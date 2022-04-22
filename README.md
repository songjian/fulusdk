# 福禄开放平台SDK

自己实现的调用福禄API的SDK。

福禄开放平台地址：[https://open.fulu.com/](https://open.fulu.com/)

## 使用Composer安装

```sh
composer require songjian/fulusdk
```

## 沙箱环境使用

```php
$sandbox_app_key = 'i4esv1l+76l/7NQCL3QudG90Fq+YgVfFGJAWgT+7qO1Bm9o/adG/1iwO2qXsAXNB';
$sandbox_app_secret = '0a091b3aa4324435aab703142518a8f7';
$fulu = new \Fulu\Fulu($sandbox_app_key, $sandbox_app_secret, true);
$fulu->$fulu->orderMobileAdd('15972368779', 100, [CUSTOMER_ORDER_NO]);
```
