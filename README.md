<h1 align="center"> 系统接入工具包 </h1>

<p align="center"> Operation SDK.</p>


## Composer Installing

```shell
$ composer require seebyyu/blh
```

## Usage
Config
```php

return [

    /**
     * 运营系统三方账号基本信息，联系客服发放
     */
    'app_id' => 'appid',
    'secret' => 'secret',
    
    /**
     * 活动系统
     */
    'activity' => [
        'app_id' => 'app_id',
        'secret' => 'secret',
    ],

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

Example
```php

// 获取通知消息
$app = \Blh\Factory::operation($config);

// 获取通知列表
$app->notice->getList();

// 发送短信
$app->sms->send('139****5804', 'see hi', '签名');

// 活动系统
$app = \Blh\Factory::activity($config);

// 活动id
$aid = '1000002';

// 用户id
$mid = '000-00001';

// 订单id
$unique_id = date('Ymd');

// 前端同步登录
$app->synchronizationLogin($aid, $mid);

// 活动列表
$app->activityList();

// 增加权益
$app->equityAdd($mid, 10, $unique_id, $aid);

// 检查权益充值
$app->equityFind($unique_id);

// 商户同步登陆
$app->mainLogin($aid, 'https://www.baiduc.com');

```

Laravel
```php

use Symfony\Component\Cache\Adapter\RedisAdapter;

// 设置应用前缀
config()->set('database.redis.options.prefix', '');

// 替换缓存容器
$app->rebind('cache', new RedisAdapter(app('redis')->connection()->client()));

```

## Rely on
- pimple/pimple
- guzzlehttp/guzzle

## License

MIT