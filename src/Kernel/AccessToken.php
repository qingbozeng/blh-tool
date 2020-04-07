<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/4/1 - 11:26 上午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Kernel;


use Blh\Kernel\Exceptions\HttpException;
use Blh\Kernel\Exceptions\InvalidArgumentException;

abstract class AccessToken
{

    /**
     * @var ServiceContainer
     */
    protected $app;

    /**
     * @var string
     */
    protected $requestMethod = 'GET';

    /**
     * @var array
     */
    protected $token;

    /**
     * @var string
     */
    protected $tokenKey = 'access_token';

    /**
     * @var string
     */
    protected $endpointToGetToken;

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @return array
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function getRefreshedToken()
    {
        return $this->getToken(true);
    }

    /**
     * @param string $token
     * @param int $lifetime
     * @return $this
     */
    public function setToken(string $token, int $lifetime = 7200)
    {
        return $this;
    }

    /**
     * @param bool $refresh
     * @return array
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function getToken(bool $refresh = false): array
    {

        $token = $this->requestToken($this->getCredentials());

        $this->setToken($token[$this->tokenKey], $token['expires_in'] ?? 7200);

        return $token;
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

        if (empty($result[$this->tokenKey])) {
            throw new HttpException('Request fail: '.json_encode($result, JSON_UNESCAPED_UNICODE), $response);
        }

        return $result;
    }

    /**
     * @param array $credentials
     * @return mixed
     * @throws InvalidArgumentException
     */
    protected function sendRequest(array $credentials)
    {
        $options = [
            ('GET' === $this->requestMethod) ? 'query' : 'json' => $credentials,
        ];

        if (empty($this->endpointToGetToken)) {
            throw new InvalidArgumentException('No endpoint for access token request.');
        }

        return $this->app['http_client']->request($this->requestMethod, $this->endpointToGetToken, $options);
    }

    /**
     * Credential for get token.
     *
     * @return array
     */
    abstract protected function getCredentials(): array;
}