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
 * @property \Blh\Operation\Order\Client            $order
 * @property \Blh\Operation\Notice\Client           $notice
 * @property \Blh\Operation\Merchandise\Client      $merchandise
 * @property \Blh\Operation\Sms\Client              $sms
 * @property \Blh\Operation\Address\Client          $address
 * @property \Blh\Operation\Store\Client            $store
 * @property \Blh\Operation\Logistic\Client         $logistic
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