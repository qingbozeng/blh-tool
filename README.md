<h1 align="center"> 系统接入工具包 </h1>

<p align="center"> BLH SDK.</p>

## Requirement

1. PHP >= 7.2
2. **[Composer](https://getcomposer.org/)**

## Composer Installing

```shell
$ composer require "seebyyu/blh:^1.1" -vvv
```

## Usage
Config
```php

return [

    /**
     * 运营系统, 活动系统 三方账号基本信息，联系客服发放
     */
    'app_id' => 'appid',
    'secret' => 'secret',

    'sms' => [
        'sign' =>  'test'
    ],

    /**
     * 配置缓存前缀
     */
    'token' => [
        'prefix' => 'blh_tool'
    ],

    /**
     * http 客户端
     * http://docs.guzzlephp.org/en/stable/request-config.html
     */
    'http' => [
        'verify' => false
    ]
];

```

Operation Example
```php

// 运营系统
$app = \Blh\Factory::operation($config);

// 获取通知列表
$app->notice->getList();

// 发送短信
$app->sms->send('139****5804', 'see hi', '签名');
```

Activity Example
```php
// 活动系统
$app = \Blh\Factory::activity($config);

// 前端同步登录
$app->synchronizationLogin('1000002', '000-00001');

// 活动列表
$app->activityList();

// 增加权益
$app->equityAdd('000-00001', 10, date('Ymd'), '1000002');

// 检查权益充值
$app->equityFind(date('Ymd'));

// 商户同步登陆
$app->mainLogin('1000002', 'https://www.baiduc.com');
```

Laravel
```php

use Symfony\Component\Cache\Adapter\RedisAdapter;

// 设置应用前缀
config()->set('database.redis.options.prefix', '');

// 替换缓存容器,token存在redis里变相解决分布式共享token问题
$app->rebind('cache', new RedisAdapter(app('redis')->connection()->client()));

```

## Rely on
- pimple/pimple
- guzzlehttp/guzzle

## License

MIT