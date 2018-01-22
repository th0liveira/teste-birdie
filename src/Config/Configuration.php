<?php
/**
 * Teste Birdie
 *
 * @author Thiago H Oliveira <thiago.h.oliv@gmail.com>
 */
namespace Config;

/**
 * Class Configuration
 *
 * @author     Thiago H Oliveira <thiago.h.oliv@gmail.com>
 */
final class Configuration
{
    /**
     * Configuration PATH
     * @const string
     */
    const CONFIG_PATH = 'config/config.php';

    /**
     * Mongo Config Key
     * @const string
     */
    const CONFIG_KEY_MONGO = 'mongo';

    /**
     * Mongo/Host Config Key
     * @const string
     */
    const CONFIG_KEY_MONGO_HOST = 'host';

    /**
     * Mongo/Port Config Key
     * @const string
     */
    const CONFIG_KEY_MONGO_PORT = 'port';

    /**
     * Mongo/Db Config Key
     * @const string
     */
    const CONFIG_KEY_MONGO_DB = 'db';

    /**
     * Mongo/Collection Config Key
     * @const string
     */
    const CONFIG_KEY_MONGO_COLLECTION = 'collection';

    /**
     * Redis Config Key
     * @const string
     */
    const CONFIG_KEY_REDIS = 'redis';

    /**
     * Redis/Host Config Key
     * @const string
     */
    const CONFIG_KEY_REDIS_HOST = 'host';

    /**
     * Redis/Port Config Key
     * @const string
     */
    const CONFIG_KEY_REDIS_PORT = 'port';

    /**
     * Redis/Db Config Key
     * @const string
     */
    const CONFIG_KEY_REDIS_DB = 'db';

    /**
     * General Config Key
     * @const string
     */
    const CONFIG_KEY_GENERAL = 'general';

    /**
     * General/Pagination Size ConfigKey
     * @const string
     */
    const CONFIG_KEY_GENERAL_PAGINATION_SIZE = 'pagination_size';

    /**
     * Default Pagination Size
     * @const integer
     */
    const DEFAULT_PAGINATION_SIZE = 10;

    /**
     * Configuration Data
     * @var array
     */
    protected $configurationData;

    /**
     * Instance
     * @var Configuration
     */
    protected static $instance;

    /**
     * Configuration constructor.
     */
    public function __construct()
    {
        $this->loadConfigurationData();
    }

    /**
     * Create Instance (alias to getInstance)
     *
     * @return Configuration
     */
    public static function createInstance()
    {
        return self::getInstance();
    }

    /**
     * Get Instance
     *
     * @return Configuration
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Configuration();
        }

        return self::$instance;
    }

    /**
     * Load Configuration
     *
     * @return void
     */
    protected function loadConfigurationData()
    {
        $fullPath = __DIR__ . '/../../' . self::CONFIG_PATH;

        if (file_exists($fullPath) === false) {
            throw new \Exception('Configuration File Not Found (./config/config.php)');
        }

        $this->configurationData = require $fullPath;
    }

    /**
     * Get Configuration
     *
     * @param $key
     *
     * @return mixed|null
     */
    public function getConfiguration($key)
    {
        if (isset($this->configurationData[$key]) === false) {
            return null;
        }

        return $this->configurationData[$key];
    }

    /**
     * Get General Settings
     *
     * @return array
     */
    public function getGeneralSettings()
    {
        return $this->configurationData[self::CONFIG_KEY_GENERAL];
    }

    /**
     * Get Pagination Size
     *
     * @return integer
     */
    public function getPaginationSize()
    {
        $generalSetting = $this->getGeneralSettings();

        if (isset($generalSetting[self::CONFIG_KEY_GENERAL_PAGINATION_SIZE]) === false) {
            return self::DEFAULT_PAGINATION_SIZE;
        }

        return $generalSetting[self::CONFIG_KEY_GENERAL_PAGINATION_SIZE];
    }

    /**
     * Get Mongo Settings
     *
     * @return array
     */
    public function getMongoSettings()
    {
        return $this->configurationData[self::CONFIG_KEY_MONGO];
    }

    /**
     * Get Redis Settings
     *
     * @return array
     */
    public function getRedisSettings()
    {
        return $this->configurationData[self::CONFIG_KEY_REDIS];
    }
}
