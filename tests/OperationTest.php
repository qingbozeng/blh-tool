<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/5/22 - 8:44 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------
namespace blh\tests;


use Blh\Factory;
use Blh\Operation\Exceptions\BusinessException;
use PHPUnit\Framework\TestCase;

class OperationTest extends TestCase
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

        'sms' => [
            'sign' =>  'test'
        ],

        /**
         * 配置缓存前缀
         * - 多数应用于令牌
         */
        'token' => [
            'prefix' => 'blh_tool',
        ],

        /**
         * http 客户端
         * http://docs.guzzlephp.org/en/stable/request-config.html
         */
        'http' => [
            'base_uri' => 'https://t.blhapi.li91.com',
            'verify' => false
        ],
    ];

    /**
     * init
     *
     * @return void
     */
    public function setUp()
    {
        $this->app = Factory::operation($this->config);
    }

    /**
     * Request Token
     *
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testToken()
    {
        $this->assertIsString($this->app->token->getRefreshedToken());
    }

    /**
     * 收货地址三级
     *
     * @throws \Blh\Kernel\Exceptions\InvalidArgumentException
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testAddress()
    {
        $this->assertIsArray($this->app->address->list());
    }

    /**
     * 运营系统消息列表
     *
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testNotice()
    {
        $this->assertArrayHasKey('notice_num', $this->app->notice->getList());
    }

    /**
     * 发送短信
     *
     * @throws BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSms()
    {
        $result = false;

        try {
            $result = $this->app->sms->send('1398****804', 'see hi');
        }catch (BusinessException $exception){
            $errMsg = $exception->getMessage();
        }

        $this->assertNull($result, $errMsg ?? '');
    }

    /**
     * 订单发货信息查询（实物订单）
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testOrderCreate()
    {

        $result = false;

        //  是否为京东下单
        $isJD = false;

        $attr = [
            //  创建订单属性,详见文档说明
            'sendcms' => '',
            //  三方客户订单编号
            'orderId' => '',
            //  订单类型（ 1:自营实物订单，2虚拟卡券订单，3：直充产品订单，4：京东实物订单 ）
            'isvirtual' => '',
            //  shouhuo_phone
            'shouhuo_phone' => '',
            //  订单商品
            'products' => [
                [
                    //  商品数量
                    "number" => 1,
                    //  商品id
                    "itemId" => ''
                ]
            ],
            //  收货人姓名，实物类订单必选
            'shouhuo_name' => "" ,
            //  收货地址区域（level1）实物类订单必选
            'provinceId' => "",
            //  收货地址区域（level2）实物类订单必选
            'cityId' => "",
            //  收货地址区域（level3）实物类订单必选
            'countyId' => "",
            //  收货地址区域（level4）实物类订单必选，为空则=0
            'townId' => "",
            //  收货详细地址，实物订单必选
            'shouhuo_addr' => "",
            //  收货地址区域选项类型，实物订单必选 1：地址库ID，2：文字
            'addr_type' => 1,
        ];

        try {
            $result = $this->app->order->create($attr, $isJD);
        }catch (BusinessException $exception) {
            $errMsg = $exception->getMessage();
        }

        $this->assertIsArray($result, $errMsg ?? '');
    }

    /**
     * 订单发货信息查询（实物订单）
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testOrderShipment()
    {

        //  订单号
        $order_sn = '000000111111000000111111';
        $result = false;

        try {
            $result = $this->app->order->shipment($order_sn);
        }catch (BusinessException $exception) {
            $errMsg = $exception->getMessage();
        }

        $this->assertIsArray($result, $errMsg ?? '');
    }

    /**
     * 订单详情
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testOrderDetail()
    {

        //  订单号
        $order_sn = '000000111111000000111111';
        $result = false;

        try {
            $result = $this->app->order->detail($order_sn);
        }catch (BusinessException $exception) {
            $errMsg = $exception->getMessage();
        }

        $this->assertIsArray($result, $errMsg ?? '');
    }

    /**
     * 取消订单(仅限京东订单)
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testOrderCancel()
    {

        //  订单号
        $order_sn = '000000111111000000111111';
        $result = false;

        try {
            $result = $this->app->order->cancel($order_sn);
        }catch (BusinessException $exception) {
            $errMsg = $exception->getMessage();
        }

        $this->assertIsArray($result, $errMsg ?? '');
    }

}