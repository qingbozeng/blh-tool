<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/4/2 - 10:02 上午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Operation\Notice;


use Blh\Operation\Kernel\BaseClient;

class Client extends BaseClient
{

    /**
     * @var string
     */
    protected $closeNotice = 'Notic/doNotics';

    /**
     * @var string
     */
    protected $noticeList = 'Notic/getNotics';

    /**
     * 关闭消息
     *
     * @param $notice_id
     * @return array
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function close($notice_id)
    {
        return $this->httpPost($this->closeNotice, [
            'notice_ids' => is_array($notice_id) ?: explode(',', $notice_id)
        ]);
    }

    /**
     * @return array
     * @throws \Blh\Operation\Exceptions\BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getList()
    {
        return $this->httpPost($this->noticeList);
    }
}