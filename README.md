<h1 align="center"> 业务系统接入工具包 </h1>

<p align="center"> Operation SDK.</p>


## Composer Installing

```shell
$ composer require seebyyu/blh -vvv
```

## Usage
配置信息
```php
    $operation = \Blh\Factory::operation([

        'app_id' => 'test',
        'secret' => 'test',

        'sms' => [
            'sign' =>  'test'
        ]
    ]);
```

##Rely on
- pimple/pimple
- guzzlehttp/guzzle
- illuminate/support

## License

MIT