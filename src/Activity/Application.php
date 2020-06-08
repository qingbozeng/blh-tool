<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/6/8 - 6:59 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------
namespace Blh\Activity;


use Blh\Kernel\ServiceContainer;
use Blh\Kernel\Exceptions\BadMethodCallException;

/**
 * Class Application.
 *
 * 同步登陆(普通用户)
 * @method \Blh\Activity\Server\Client  synchronizationLogin($activity_code = '', $member_code = '')
 *
 * 活动列表
 * @method \Blh\Activity\Server\Client  activityList()
 *
 * 增加权益
 * @method \Blh\Activity\Server\Client  equityAdd($member_code, $equity_num, $unique_id, $activity_code)
 *
 * 检索权益信息
 * @method \Blh\Activity\Server\Client  equityFind($unique_id)
 *
 * 商户后台登录
 * @method \Blh\Activity\Server\Client  mainLogin($activity_code, $back_url, $overtime = 1800)
 */
class Application extends ServiceContainer
{

    protected $defaultConfig = [
        'activity' => []
    ];

    protected $providers = [
        \Blh\Kernel\Providers\HttpClientServiceProvider::class,
        \Blh\Activity\Server\ActivityServiceProvider::class
    ];

    /**
     * call method
     *
     * @param $method
     * @param $arguments
     * @throws BadMethodCallException
     */
    public function __call($method, $arguments)
    {
        if (! method_exists($this->server, $method)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.', static::class, $method
            ));
        }

        $this->server->$method(...$arguments);
    }
}