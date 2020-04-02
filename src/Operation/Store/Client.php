<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/4/2 - 3:53 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Operation\Store;


use Blh\Operation\Kernel\BaseClient;

class Client extends BaseClient
{

    /**
     * @var string
     */
    protected $getRegionStore = 'Store/getRegionStore';

    /**
     * @var string
     */
    protected $getStoreAsNum = 'Store/getStoreAsNum';

    /**
     * @var int
     */
    protected $province;

    /**
     * @var int
     */
    protected $city;

    /**
     * @var int
     */
    protected $county;

    /**
     * @var int
     */
    protected $town;

    /**
     * @var array
     */
    protected $products = [];

    /**
     * 批量设置查询商品
     * ```
     * $items = [
     *      商品id => 商品查询数量
     * ]
     * ```
     * @param $items
     * @return $this
     */
    public function buildProducts($items)
    {

        foreach ($items as $item_id => $number) {
            $this->buildProduct($item_id, $number);
        }

        return $this;
    }

    /**
     * 构建查询数组
     *
     * @param $item_id
     * @param $number
     * @return $this
     */
    public function buildProduct($item_id, $number)
    {

        $this->products[] = [
            'itemId' => $item_id, 'number' => $number
        ];

        return $this;
    }

    /**
     * @return int
     */
    protected function getProvince(): int
    {
        return $this->province;
    }

    /**
     * @param int $province
     * @return $this
     */
    public function setProvince(int $province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * @return int
     */
    protected function getCity(): int
    {
        return $this->city;
    }

    /**
     * @param int $city
     * @return $this
     */
    public function setCity(int $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return int
     */
    protected function getCounty(): int
    {
        return $this->county;
    }

    /**
     * @param int $county
     * @return $this
     */
    public function setCounty(int $county)
    {
        $this->county = $county;

        return $this;
    }

    /**
     * @return int
     */
    protected function getTown(): int
    {
        return $this->town;
    }

    /**
     * @param int $town
     * @return $this
     */
    public function setTown(int $town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * 京东商品区域库存
     *
     * @param $itemIds string|array
     * @return array
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function regionStore($itemIds)
    {
        return $this->httpPost($this->getRegionStore, [
            'itemIds' => is_array($itemIds) ? implode(',', $itemIds) : $itemIds,
            'province' => $this->getProvince(),
            'county' => $this->getCounty(),
            'city' => $this->getCity(),
            'town' => $this->getTown()
        ]);
    }

    /**
     * 京东商品区域库存查询
     *
     * @return array
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function merchandiseStore()
    {
        return $this->httpPost($this->getStoreAsNum, [
            'province' => $this->getProvince(),
            'county' => $this->getCounty(),
            'city' => $this->getCity(),
            'town' => $this->getTown(),
            'products' => $this->products
        ]);
    }

}