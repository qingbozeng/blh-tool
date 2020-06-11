<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/6/11 - 9:28 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace blh\tests;


use PHPUnit\Framework\TestCase;
use Blh\Factory;

class ActivityTest extends TestCase
{

    /**
     * @var Factory
     */
    protected $app;

    /**
     * @var array
     */
    protected $config = [
        /**
         * 账号基本信息，联系客服发放
         */
        'app_id' => '',
        'secret' => '',
    ];

    /**
     * init 初始化应用
     *
     * @return void
     */
    public function setUp()
    {
        $this->app = Factory::activity($this->config);
    }

    /**
     * 可能会切换商户应用
     */
    public function testResetAuth()
    {
        $this->assertInstanceOf(
            'Blh\Activity\Server\Client',
            $this->app->resetAuth('app_id', 'secret')
        );
    }
}