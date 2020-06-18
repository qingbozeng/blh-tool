<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/4/2 - 10:07 上午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Operation\Merchandise;


use Blh\Operation\Kernel\BaseClient;
use Blh\Kernel\Arr;

class Client extends BaseClient
{

    /**
     * @var string
     */
    protected $getGoodInfo = 'Product/getGoodInfo';

    /**
     * @var string
     */
    protected $getGoodsId = 'Product/getGoodsId';

    /**
     * Merchandise info
     *
     * @param string $source_id
     * @return array
     *
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function detail($source_id = '') : array
    {
        return Arr::first($this->httpPost($this->getGoodInfo, ['itemId' => $source_id]));
    }

    /**
     * Merchandise Ids
     *
     * @return array
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function ids()
    {
        return $this->httpPost($this->getGoodsId);
    }
}