<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/3/31 - 5:04 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Kernel;


use Pimple\Container;

class ServiceContainer extends Container
{

    public function __construct(array $config = [], array $prepends = [])
    {
        $this->registerProviders($this->getProviders());

        parent::__construct($prepends);

        $this->userConfig = $config;
    }

    /**
     * @var array
     */
    protected $providers = [];

    /**
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * @var array
     */
    protected $userConfig = [];

    /**
     * @return array
     */
    public function getConfig()
    {
        // http://docs.guzzlephp.org/en/stable/request-options.html

        $base = [
            'http' => [
                'timeout' => 10.0,
                'base_uri' => 'https://blhapi.li91.com',
            ],
        ];

        return array_replace_recursive($base, $this->defaultConfig, $this->userConfig);
    }

    /**
     * Return all providers.
     *
     * @return array
     */
    public function getProviders()
    {
        return array_merge([
            \Blh\Kernel\Providers\ConfigServiceProvider::class
        ], $this->providers);
    }

    /**
     * @param string $id
     * @param mixed  $value
     */
    public function rebind($id, $value)
    {
        $this->offsetUnset($id);
        $this->offsetSet($id, $value);
    }

    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }
}