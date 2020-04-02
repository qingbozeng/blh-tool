<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/4/1 - 1:59 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Operation\Auth;


use \Blh\Kernel\AccessToken as BaseAccessToken;
use Blh\Kernel\Exceptions\HttpException;
use Blh\Kernel\Exceptions\InvalidArgumentException;
use Illuminate\Support\Arr;

class AccessToken extends BaseAccessToken
{

    /**
     * @var string
     */
    protected $endpointToGetToken = 'index/getToken';

    /**
     * @var string
     */
    protected $requestMethod = 'POST';

    /**
     * @var string
     */
    protected $tokenKey = 'data.token';

    /**
     * @var string
     */
    protected $tokenExpiresKey = 'data.deadline';

    /**
     * @return array
     */
    protected function getCredentials(): array
    {

        $time = date('Y-m-d H:i:s');

        return [
            'app_id' => ($app_id = $this->app['config']->get('app_id')),
            'app_key' => ($secret = $this->app['config']->get('secret')),
            'sign' => $this->getSign($time, $app_id, $secret),
            'tamptimes' => $time,
        ];
    }

    /**
     * @param $time
     * @param $app_id
     * @param $secret
     * @return string
     */
    private function getSign($time, $app_id, $secret)
    {
        return strtoupper(md5("app_id={$app_id}:app_key={$secret}:tamptimes={$time}"));
    }

    /**
     * @param array $credentials
     * @return mixed
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function requestToken(array $credentials)
    {

        $response = $this->sendRequest($credentials);
        $result = json_decode($response->getBody()->getContents(), true);

        if ($result['result'] != true) {
            throw new HttpException('Request access_token fail: '.json_encode($result, JSON_UNESCAPED_UNICODE), $response);
        }

        return $result;
    }

    /**
     * @param bool $refresh
     * @return array
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function getToken(bool $refresh = false): array
    {

        $token = Arr::dot($this->requestToken($this->getCredentials()));

        $this->setToken($token[$this->tokenKey], isset($token[$this->tokenExpiresKey]) ? (strtotime($token[$this->tokenExpiresKey]) - time()) : 7200);

        return $token;
    }
}