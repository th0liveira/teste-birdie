<?php
/**
 * Teste Birdie
 *
 * @author Thiago H Oliveira <thiago.h.oliv@gmail.com>
 */
namespace Model;

use Config\Configuration;
use Connector\Mongo;

/**
 * Class Country
 *
 * @author     Thiago H Oliveira <thiago.h.oliv@gmail.com>
 */
final class Country
{
    /**
     * Mongo Client
     * @var Mongo
     */
    protected $mongoConnector;

    /**
     * Configuration
     * @var Configuration
     */
    protected $config;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->mongoConnector   = new Mongo();
        $this->config           = new Configuration();
    }

    /**
     * Get Documents
     *
     * @param integer $page
     *
     * @return array
     */
    public function getDocuments($page = null)
    {
        $skip = $limit = null;

        if ($page !== null) {
            $pageSize   = $this->config->getPaginationSize();
            $skip       = (int) ($pageSize * ($page - 1));
            $limit      = $pageSize;
        }

        return $this->mongoConnector->getDocuments($limit, $skip);
    }

    /**
     * Get Total Documents
     *
     * @return integer
     */
    public function getTotalDocuments()
    {
        return $this->mongoConnector->countDocuments();
    }
}
