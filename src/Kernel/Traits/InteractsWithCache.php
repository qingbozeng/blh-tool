<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/4/8 - 5:36 上午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Kernel\Traits;


use Blh\Kernel\ServiceContainer;
use http\Exception\InvalidArgumentException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

trait InteractsWithCache
{
    /**
     * @var \Psr\SimpleCache\CacheInterface
     */
    protected $cache;

    /**
     * @return CacheInterface|Psr16Cache
     */
    public function getCache()
    {
        if ($this->cache) {
            return $this->cache;
        }

        if (property_exists($this, 'app') && $this->app instanceof ServiceContainer && isset($this->app['cache'])) {

            $this->setCache($this->app['cache']);

            // Fix PHPStan error
//            assert($this->cache instanceof \Psr\SimpleCache\CacheInterface);

            return $this->cache;
        }

        return $this->cache = $this->createDefaultCache();
    }

    /**
     * @param $cache
     * @return $this
     */
    public function setCache($cache)
    {

        if ($cache instanceof CacheItemPoolInterface) {

            if (!$this->isSymfony43OrHigher()) {
                throw new InvalidArgumentException(sprintf('The cache instance must implements %s', CacheInterface::class));
            }

            $cache = new Psr16Cache($cache);
        }

        $this->cache = $cache;

        return $this;
    }

    /**
     * @return Psr16Cache
     */
    protected function createDefaultCache()
    {
        return new Psr16Cache(new FilesystemAdapter('blh', 1500));
    }

    /**
     * @return bool
     */
    protected function isSymfony43OrHigher(): bool
    {
        return \class_exists('Symfony\Component\Cache\Psr16Cache');
    }
}