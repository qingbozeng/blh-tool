<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/4/2 - 10:08 上午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Operation\Merchandise;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{

    /**
     * @param Container $pimple
     */
    public function register(Container $pimple)
    {
        $pimple['merchandise'] = function ($app){
            return new Client($app);
        };
    }
}