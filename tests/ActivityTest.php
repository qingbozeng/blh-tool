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
use Blh\Vbot;

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
        $this->app = Vbot::activity($this->config);
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

    /**
     * 前端用户同步登陆
     */
    public function testSynchronizationLogin()
    {

        //  用户标实
        $mid = '0001';

        //  活动code
        $activity_code = '100003';

        $this->assertIsArray($this->app->synchronizationLogin($activity_code, $mid));
    }

    /**
     * 全部活动列表
     */
    public function testActivityList()
    {
        $this->assertIsArray($this->app->activityList());
    }

    /**
     * 增加权益
     */
    public function testEquityAdd()
    {
        $data = [
            //  用户编号
            '0001',
            //  权益数量
            '100',
            //  订单号
            'sn1993020100201',
            //  活动编号
            '100003'
        ];

        $this->assertIsArray($this->app->equityAdd(...$data));
    }

    /**
     * 检查权益
     */
    public function testEquityFind()
    {
        $this->assertIsArray($this->app->equityFind('sn1993020100201'));
    }

    /**
     * 商户登陆
     */
    public function testMainLogin()
    {

        $data = [
            //  活动编号
            '100003',
            //  会话时长默认30分钟(单位秒)
            3600
        ];

        $this->assertIsArray($this->app->mainLogin(...$data));
    }
}