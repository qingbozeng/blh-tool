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

    'sms' => [
        //  默认短信签名
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
$app->notice->getList();

// 发送短信
$app->sms->send('139****5804', 'see hi', '签名');

...
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
- illuminate/support

## License

MIT