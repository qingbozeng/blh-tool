<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/3/31 - 7:24 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Operation;

use Blh\Kernel\ServiceContainer;


/**
 * Class Application.
 *
 * @property \Blh\Operation\Order\Client            $order              //  订单列表
 * @property \Blh\Operation\Notice\Client           $notice             //  消息通知
 * @property \Blh\Operation\Merchandise\Client      $merchandise        //  商品详情
 * @property \Blh\Operation\Sms\Client              $sms                //  短信接口
 * @property \Blh\Operation\Address\Client          $address            //  收货地址
 * @property \Blh\Operation\Store\Client            $store              //  京东库存
 * @property \Blh\Operation\Logistic\Client         $logistic           //  物流信息
 */
class Application extends ServiceContainer
{

    protected $providers = [
        \Blh\Kernel\Providers\HttpClientServiceProvider::class,

        Auth\ServiceProvider::class,
        Order\ServiceProvider::class,
        Notice\ServiceProvider::class,
        Merchandise\ServiceProvider::class,
        Sms\ServiceProvider::class,
        Address\ServiceProvider::class,
        Store\ServiceProvider::class,
        Logistic\ServiceProvider::class
    ];
}