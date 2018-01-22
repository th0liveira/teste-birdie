<?php
/**
 * Teste Birdie
 *
 * @author Thiago H Oliveira <thiago.h.oliv@gmail.com>
 */
namespace Connector;

use Config\Configuration as Cfg;
use RedisDB\Client as RedisDbClient;

/**
 * Class Redis
 *
 * @author     Thiago H Oliveira <thiago.h.oliv@gmail.com>
 */
final class Redis
{
    /**
     * Redis Client
     * @var \Redis
     */
    protected $redisClient;

    /**
     * Redis constructor.
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * Create Connection
     *
     * @return void
     */
    protected function connect()
    {
        $configuration = Cfg::getInstance();
        $redisConfig = $configuration->getRedisSettings();

        $this->redisClient = new \Redis();
        $this->redisClient->connect($redisConfig[Cfg::CONFIG_KEY_REDIS_HOST], $redisConfig[Cfg::CONFIG_KEY_REDIS_PORT]);
        $this->redisClient->select($redisConfig[Cfg::CONFIG_KEY_REDIS_DB]);
    }

    /**
     * Get
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->redisClient->get($key);
    }

    /**
     * Save
     *
     * @param string $key
     * @param string $value
     *
     * @return integer
     */
    public function save($key, $value)
    {
        return $this->redisClient->set($key, $value);
    }
}
