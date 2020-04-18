<h1 align="center"> 系统接入工具包 </h1>

<p align="center"> Operation SDK.</p>


## Composer Installing

```shell
$ composer require seebyyu/blh -vvv
```

## Usage
Config
```php

return [

    /**
     * 账号基本信息，联系客服发放
     */
    'app_id' => 'appid',
    'secret' => 'secret',

    'sms' => [

        //  默认短信签名
        'sign' =>  'test'
    ],

    /**
     * 配置缓存前缀
     * - 多数应用于令牌
     */
    'cache' => [

        'prefix' => 'blh_tool',

        //  Driver list: file or redis, default file
        'driver' => RedisAdapter::class,
        'option' => [

        ]
    ],

    /**
     * http 客户端
     * http://docs.guzzlephp.org/en/stable/request-config.html
     *
     * - base_uri 测试环境应该接口域名
     */
    'http' => [
        'verify' => false
    ]
];

```

Example
```php

# 获取通知消息
$app = \Blh\Factory::operation($config);
$app->notice->getList();

# 发送短信
$app->sms->send('139****5804', 'see hi', '签名');

...
```

## Rely on
- pimple/pimple
- guzzlehttp/guzzle
- illuminate/support

## License

MIT