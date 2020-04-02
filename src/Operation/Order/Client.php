<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/4/1 - 5:41 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Operation\Order;


use Blh\Operation\Kernel\BaseClient;

class Client extends BaseClient
{

    /**
     * @var string
     */
    protected $createOrder= 'Order/createOrder';

    /**
     * @var string
     */
    protected $confrimJdOrder = 'Order/confrimJdOrder';

    /**
     * @var string
     */
    protected $getOrderInfo = 'Order/getOrderInfo';

    /**
     * @var string
     */
    protected $cancelOrder = 'Order/cancelJdOrder';

    /**
     * @var string
     */
    protected $getOrderShipment = 'Order/getOrderShipment';

    /**
     * 统一下单
     *
     * @param array $arr
     * @param bool $is_jd
     * @return array
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($arr = [], $is_jd = false)
    {
        return $this->httpPost($is_jd ? $this->confrimJdOrder : $this->createOrder, $arr);
    }

    /**
     * 订单详情
     *
     * @param string $order_sn
     * @return array
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function detail($order_sn = '')
    {
        return $this->httpPost($this->getOrderInfo, ['order_sn' => $order_sn]);
    }

    /**
     * 取消订单(仅限京东订单)
     *
     * @param string $order_sn
     * @return array
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancel($order_sn = '')
    {
        return $this->httpPost($this->cancelOrder, ['order_sn' => $order_sn]);
    }

    /**
     * 订单发货信息查询（实物订单）
     *
     * @param string $order_sn
     * @return array
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function shipment($order_sn = '')
    {
        return $this->httpPost($this->getOrderShipment, ['order_sn' => $order_sn]);
    }
}