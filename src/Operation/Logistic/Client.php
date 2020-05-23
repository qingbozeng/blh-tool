<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/4/2 - 3:49 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Operation\Logistic;


use Blh\Operation\Kernel\BaseClient;

class Client extends BaseClient
{

    /**
     * @var string
     */
    protected $getExpressList = "Express/getExpressList";

    /**
     * @var string
     */
    protected $getOrderExpress = "Special/getOrderExpress";

    /**
     * @var string
     */
    protected $company;

    /**
     * @return string
     */
    protected function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     * @return $this
     */
    public function setCompany(string $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * 快递公司查询
     *
     * @return array
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function company()
    {
        return $this->httpPost($this->getExpressList);
    }

    /**
     * 根据物流单号查询发货信息（实物订单）
     *
     * @param $nums
     * @return array
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function express($nums)
    {
        return $this->httpPost($this->getOrderExpress, [
            'nums' => $nums,
            'company' => $this->getCompany()
        ]);
    }

}