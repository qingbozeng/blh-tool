<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/4/1 - 5:49 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Operation\Kernel;


use Blh\Operation\Application;
use Blh\Operation\Exceptions\BusinessException;

class BaseClient
{

    /**
     * @var
     */
    protected $app;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $token;

    /**
     * BaseClient constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->token = $this->app['token']->getToken()['data.token'];

        $this->setHttpClient($this->app['http_client']);
    }

    /**
     * @param $httpClient
     * @return $this
     */
    protected function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * @param string $url
     * @param array $query
     * @return array
     * @throws BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function httpGet(string $url, array $query = [])
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * @param string $url
     * @param array $data
     * @return array
     * @throws BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function httpPost(string $url, array $data = [])
    {
        return $this->request($url, 'POST', [
            'body' => \GuzzleHttp\json_encode(array_merge($data, [
                'token' => $this->token
            ]))]
        );
    }

    /**
     * @param $url
     * @param $method
     * @param array $option
     * @return array
     *
     * @throws BusinessException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request($url, $method, $option = [])
    {

        $response = $this->httpClient->request($method, $url, $option);

        //  format array
        $response = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        if( !isset($response['result']) || $response['result'] != true ){

            throw new BusinessException($response['desc'], $response['errCode']);
        }

        return $response['data'];
    }

}