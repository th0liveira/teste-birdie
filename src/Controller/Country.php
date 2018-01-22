<?php
/**
 * Teste Birdie
 *
 * @author Thiago H Oliveira <thiago.h.oliv@gmail.com>
 */
namespace Controller;

use Config\Configuration;
use Connector\Redis;
use Model\Country as CountryModel;

/**
 * Class Country
 *
 * @author     Thiago H Oliveira <thiago.h.oliv@gmail.com>
 */
final class Country
{
    /**
     * Model
     * @var CountryModel
     */
    protected $model;

    /**
     * Redis
     * @var Redis
     */
    protected $redis;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->model = new CountryModel();
        $this->redis = new Redis();
    }

    /**
     * List Page
     *
     * @param integer $page
     *
     * @return string
     */
    public function getList($page = 1)
    {
        $cacheKey = "list_page_{$page}";

        $return = $this->redis->get($cacheKey);

        if ($return) {
            header('Redis-Cache: TRUE');
            return $return;
        }

        $content = [
            'documents'     => $this->getDocuments($page),
            'pagination'    => $this->getPagination($page),
        ];

        $return = json_encode($content);

        $this->redis->save($cacheKey, $return);

        header('Redis-Cache: FALSE');

        return $return;
    }

    /**
     * Get Pagination
     *
     * @return array
     */
    protected function getPagination($page)
    {
        $currentPage = $page;

        $config = Configuration::getInstance();

        $return = [
            'prev'  => true,
            'pages' => [],
            'next'  => true,
        ];

        $totalDocuments = $this->model->getTotalDocuments();

        $totalPage      = $totalDocuments / $config->getPaginationSize();

        if ($totalPage > round($totalPage)) {
            $totalPage = round($totalPage) + 1;
        }

        if ($page === 1) {
            $return['prev']  = false;
            $return['pages'] = range(1, 11);
            return $return;
        }

        if ($page === $totalPage) {
            $return['next']  = false;
            $return['pages'] = range($totalPage-11, $totalPage);
            return $return;
        }

        if ($page > $totalPage) {
            $page = $totalPage;
        }

        $pages = [];

        for (; $page > 0; $page--) {
            if (count($pages) > 5 || $page == 0) {
                break;
            }
            $pages[] = $page;
        }

        $page = max($pages);

        while ($page < $totalPage && count($pages) < 11) {
            $pages[] = ++$page;

            if ($page > $totalPage) {
                break;
            }
        }

        while (count($pages) < 11) {
            $pages[] = min($pages) - 1;
        }

        if ($currentPage == $totalPage) {
            $return['next']  = false;
        }

        sort($pages);
        $return['pages'] = $pages;

        return $return;
    }

    /**
     * Get Documents
     *
     * @param integer $page
     *
     * @return array
     */
    protected function getDocuments($page)
    {
        $documents = [];

        foreach ($this->model->getDocuments($page) as $doc) {
            $documents[] = [
                'code'   => $doc->code,
                'name'   => $doc->name,
                'custom' => "({$doc->code}) {$doc->name}"
            ];
        }

        return $documents;
    }

    /**
     * Export Data To File (csv|excel}
     *
     * @return string
     */
    public function exportDataToFile()
    {
        $documents = $this->getDocuments(null);

        if (count($documents) == 0) {
            return null;
        }

        ob_start();

        $df = fopen("php://output", 'w');
        fputcsv($df, array_keys(reset($documents)));

        foreach ($documents as $row) {
            fputcsv($df, $row);
        }

        fclose($df);

        return ob_get_clean();
    }
}
