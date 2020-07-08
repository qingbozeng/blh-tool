<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/4/2 - 2:28 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Operation\Address;


use Blh\Kernel\Exceptions\InvalidArgumentException;
use Blh\Operation\Kernel\BaseClient;
use Blh\Kernel\Arr;

class Client extends BaseClient
{

    /**
     * 一级
     *
     * @var int
     */
    const GRADE_ONE     = 1;

    /**
     * 二级
     *
     * @var int
     */
    const GRADE_TOW     = 2;

    /**
     * 三级
     *
     * @var int
     */
    const GRADE_THREE   = 3;

    /**
     * 四级
     *
     * @var int
     */
    const GRADE_FOUR    = 4;

    /**
     * @var string
     */
    protected $detailPort = 'Area/getAreaName';

    /**
     * @var array
     */
    protected static $gradePorts = [
        self::GRADE_ONE     => 'Area/getProvince',
        self::GRADE_TOW     => 'Area/getcity',
        self::GRADE_THREE   => 'Area/getCounty',
        self::GRADE_FOUR    => 'Area/getTown',
    ];

    /**
     * 地址列表
     *
     * @param int $id
     * @param int $grade
     * @return array
     * @throws InvalidArgumentException
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list($id = 0, $grade = self::GRADE_ONE)
    {

        if (!isset($grade, self::$gradePorts)){
            throw new InvalidArgumentException('Invalid does not exist grade');
        }

        return Arr::first($this->httpPost(self::$gradePorts[$grade], (empty($id) ? [] : ['area_id' => $id])));
    }

    /**
     * 地址详情
     *
     * @param $id
     * @return array
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function detail($id)
    {

        $ids = explode(',', $id);

        $response = array_filter($this->httpPost($this->detailPort, ['area_ids' => implode(',', $ids)]));

        return count($ids) > 0 ? $response : Arr::first($response);
    }
}