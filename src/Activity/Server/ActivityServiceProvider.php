<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/6/8 - 7:44 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------
namespace Blh\Activity\Server;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ActivityServiceProvider implements ServiceProviderInterface
{

    /**
     * @param Container $pimple
     */
    public function register(Container $pimple)
    {
        $pimple['server'] = function ($app){
            return  new Client($app, $app->config);
        };
    }
}