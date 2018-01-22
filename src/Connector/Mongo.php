<?php
/**
 * Teste Birdie
 *
 * @author Thiago H Oliveira <thiago.h.oliv@gmail.com>
 */
namespace Connector;

use Config\Configuration as Cfg;
use MongoDB\Client as MongoDbClient;

/**
 * Class Mongo
 *
 * @author     Thiago H Oliveira <thiago.h.oliv@gmail.com>
 */
final class Mongo
{
    /**
     * Mongo Client
     * @var \MongoClient
     */
    protected $mongoClient;

    /**
     * Mongo DB
     * @var \MongoDB
     */
    protected $mongoDb;

    /**
     * Mongo constructor.
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
        $mongoConfig = $configuration->getMongoSettings();

        $connectionString = "mongodb://{$mongoConfig[Cfg::CONFIG_KEY_MONGO_HOST]}:{$mongoConfig[Cfg::CONFIG_KEY_MONGO_PORT]}";

        $this->mongoClient = new MongoDbClient($connectionString);

        $this->mongoDb = $this->mongoClient->selectDatabase($mongoConfig[Cfg::CONFIG_KEY_MONGO_DB]);
    }

    /**
     * Get Documents
     *
     * @param integer $limit
     * @param integer $skip
     *
     * @throws \Exception
     *
     * @return array
     */
    public function getDocuments($limit = null, $skip = null)
    {
        $configuration = Cfg::getInstance();
        $mongoConfig = $configuration->getMongoSettings();

        $collection = $this->mongoDb->selectCollection($mongoConfig[Cfg::CONFIG_KEY_MONGO_COLLECTION]);

        $results = $collection->find([], [
            'limit' => $limit,
            'skip'  => $skip,
        ]);

        $return  = [];

        foreach ($results as $result) {

            $return[] = $result;
        }

        return $return;
    }

    /**
     * Count Documents
     *
     * @throws \Exception
     *
     * @return integer
     */
    public function countDocuments()
    {
        $configuration = Cfg::getInstance();
        $mongoConfig = $configuration->getMongoSettings();

        $collection = $this->mongoDb->selectCollection($mongoConfig[Cfg::CONFIG_KEY_MONGO_COLLECTION]);

        return $collection->count();
    }
}
