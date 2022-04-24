# 福禄开放平台SDK

自己实现的调用福禄API的SDK。

福禄开放平台地址：[https://open.fulu.com/](https://open.fulu.com/)

## 使用Composer安装

```sh
composer require songjian/fulusdk
```

## 使用沙箱环境

Fulu类实例化时app_key和app_secret参数传任意值，实例化后调用`sandbox(true)`方法。

```php
$fulu = new \Fulu\Fulu('', '');
$fulu->sandbox(true);
$fulu->$fulu->orderMobileAdd('15972368779', 100, [CUSTOMER_ORDER_NO]);
```

## 运行PHPUnit测试

```sh
vendor/bin/phpunit test/FuluTest.php
```