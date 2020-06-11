<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/6/8 - 7:45 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Activity\Server;


use Blh\Kernel\Config;

class Client
{

    /**
     * 前端接口地址
     */
    const FONT_END_API = 'https://activ1.li91.net';

    /**
     * 后端接口地址
     */
    const BACKEND_API = 'http://activ1.li91.net';

    /**
     * 查询活动列表
     */
    const ACTIVITY_LIST = '/api/activity/list';

    /**
     * 添加权益
     */
    const EQUITY_ADD = '/api/equity/add';

    /**
     * 权益添加结果查询
     */
    const EQUITY_FIND = '/api/query/result';

    /**
     * 企业同步登陆
     */
    const MAIN_LOGIN = '/api/main/login';

    /**
     * 同步登陆接口
     */
    const SYNCHRONOUS_LOGIN= '/api/synchronization/login';

    /**
     * 秘钥
     *
     * @var string
     */
    protected $salt;

    /**
     * App id
     *
     * @var string
     */
    protected $appId;

    /**
     * @var
     */
    protected $app;

    /**
     * Client constructor.
     * @param $app
     * @param $config
     */
    public function __construct($app, Config $config)
    {
        $this->app = $app;

        $this->resetAuth($config->get('app_id'), $config->get('secret'));
    }

    /**
     * @param $app_id
     * @param $secret
     * @return $this
     */
    public function resetAuth($app_id, $secret)
    {

        $this->setAppId($app_id);
        $this->setSalt($secret);

        return $this;
    }

    /**
     * @param $appId
     * @return $this
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;

        return $this;
    }

    /**
     * @param $salt
     * @return $this
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return string
     */
    protected function getAppId()
    {
        return $this->appId;
    }

    /**
     * @return string
     */
    private function getSalt()
    {
        return $this->app['config']->get('secret');
    }

    /**
     * getArr  对数组进行正向排序
     * @param $arr
     * @return mixed
     */
    protected function getArr(array $arr)
    {
        ksort($arr);
        foreach( $arr as $key => $value ) {
            if( empty($value) && $value !== '0' ) {
                unset($arr[ $key ]);
                continue;
            }
            if( is_array($value) ) {
                $arr[ $key ] = $this->getArr($value);
            }
        }

        return $arr;
    }

    /**
     * getSign  生成sign
     * @param array $arr
     * @return bool|string
     */
    protected function getSignature(array $arr)
    {

        if( !is_array($arr) || empty($arr) ) {
            return false;
        }

        //对数组进行字典序排序

        $arr = $this->getArr($arr);

        $str = '';
        foreach( $arr as $key => $value ) {
            if( $key == 'sign' ) {
                continue;
            }
            if( !is_array($value) ) {
                if( $str == '' ) {
                    $str = $key . '=' . $value;
                } else {
                    $str = $str . '&' . $key . '=' . $value;
                }
            } else {
                if( $str == '' ) {
                    $str = $key . '=' . json_encode($value , JSON_UNESCAPED_UNICODE);
                } else {
                    $str = $str . '&' . $key . '=' . json_encode($value , JSON_UNESCAPED_UNICODE);
                }
            }
        }

        $str  = $str . '&appSecret=' . $this->getSalt();

        $sign = strtoupper(md5($str));

        return $sign;
    }

    /**
     * checkSignature  验签
     * @param array $arr
     * @return bool
     */
    public function checkSignature(array $arr = [])
    {
        if( !is_array($arr) || empty($arr) ) {
            return false;
        }

        $sign = $this->getSignature($arr);

        return $arr['sign'] === $sign;
    }

    /**
     * http 客户端
     *
     * @param mixed ...$option
     * @return string
     */
    protected function request(...$option)
    {
        return self::result_format($this->app->http_client->request(...$option));
    }

    /**
     * 格式化获取返回参数
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return string
     */
    protected static function result_format(\Psr\Http\Message\ResponseInterface $response)
    {
        return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 格式化请求凭证
     *
     * @param array $certificate
     * @return array|bool[]|string[]
     */
    public function certificateFormat($certificate = [])
    {

        //  公共参数
        $certificate += [
            'key' => $this->getAppId(),
            'request_time' => time(),
            'rand_str' => time()
        ];

        //  内容编码
        $certificate += [
            'sign' => $this->getSignature($certificate),
        ];

        return $certificate;
    }

    /**
     * 同步登陆
     * @param string $activity_code 活动code
     * @param string $member_code 用户code
     * @return string
     */
    public function synchronizationLogin($activity_code = '', $member_code = '')
    {

        $certificate = $this->certificateFormat([
            'activity_code' => $activity_code,
            'member_code' => $member_code
        ]);

        return $this->request('post', self::SYNCHRONOUS_LOGIN, [
            'base_uri' => self::FONT_END_API, 'form_params' => $certificate
        ]);
    }

    /**
     * 活动列表
     *
     * status 0:未开始 1:活动中 2:暂停中 3:已结束
     * type 1概率类，2问答类，3权益类，4助力类
     * @return string
     */
    public function activityList()
    {
        return $this->request('post', self::ACTIVITY_LIST, [
            'base_uri' => self::BACKEND_API, 'form_params' => $this->certificateFormat()
        ]);
    }

    /**
     * 权益增加
     *
     * @param $member_code string 用户编号
     * @param $equity_num int 权益数量
     * @param $unique_id string 流水id，可以理解成订单号
     * @param $activity_code string 活动编号
     * @return string
     */
    public function equityAdd($member_code, $equity_num, $unique_id, $activity_code)
    {

        $certificate = $this->certificateFormat([
            'unique_id' => $unique_id,
            'equity_num' => $equity_num,
            'member_code' => $member_code,
            'activity_code' => $activity_code,
        ]);

        return $this->request('post', self::EQUITY_ADD, [
            'base_uri' => self::BACKEND_API, 'form_params' => $certificate
        ]);
    }

    /**
     * 根据订单查询权益列表
     *
     * @param $unique_id
     * @return string
     */
    public function equityFind($unique_id)
    {

        $certificate = $this->certificateFormat([
            'unique_id' => $unique_id,
        ]);

        return $this->request('post', self::EQUITY_FIND, [
            'base_uri' => self::BACKEND_API, 'form_params' => $certificate
        ]);
    }

    /**
     * 商户后台登录
     *
     * @param string $activity_code 活动编号
     * @param string $back_url 跳到原网页的链接
     * @param int $overtime 超时时间单位秒
     * @return string
     */
    public function mainLogin($activity_code, $back_url, $overtime = 1800)
    {

        $certificate = $this->certificateFormat([
            'activity_code' => $activity_code,
            'back_url' => $back_url,
            'overtime' => $overtime
        ]);

        return $this->request('post', self::MAIN_LOGIN, [
            'base_uri' => self::BACKEND_API, 'form_params' => $certificate
        ]);
    }
}