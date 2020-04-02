<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/3/31 - 4:35 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace EasyWeChat\Tests;

use Blh\Operate\Application;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Pimple\Container;

class TestCase extends BaseTestCase
{

    public function testCall()
    {

        $vales["db"] = function() {
            $dsn = 'mysql:dbname=testdb;host=127.0.0.1';
            $user = 'dbuser';
            $password = 'dbpass';
            return new \PDO($dsn, $user, $password);
        };

//        $c = new Container($values);
        $c = new Container($vales);

        var_dump($vales);


//        return true;
    }
}