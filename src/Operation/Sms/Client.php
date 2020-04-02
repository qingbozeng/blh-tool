<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/4/2 - 11:34 上午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Operation\Sms;


use Blh\Operation\Kernel\BaseClient;

class Client extends BaseClient
{

    protected $sendSms = 'Sms/SendSms';

    /**
     * @param $phone
     * @param $content
     * @param $sign
     * @return array
     *
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send($phone, $content, $sign = '')
    {
        return $this->httpPost($this->sendSms, [
            'mobile' => $phone, 'content' => $content,
            'sign' => $sign ?: $this->app['config']->get('sms.sign')
        ]);
    }
}