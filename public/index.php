<?php
/**
* Teste Birdie
*
* @author Thiago H Oliveira <thiago.h.oliv@gmail.com>
*/

require __DIR__ . '/../vendor/autoload.php';

$action = (isset($_GET['action']) === true ? $_GET['action'] : null);

$controllerCountry = new Controller\Country();

switch ($action) {
    case 'list':
        $page = (int) (isset($_GET['page']) === true ? $_GET['page'] : 0);
        header('Content-type: application/json');
        echo $controllerCountry->getList($page);
        break;

    case 'exportCsv':
        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename=export.csv");
        header("Content-Transfer-Encoding: binary");

        echo $controllerCountry->exportDataToFile($page);
        break;

    case 'exportExcel':
        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Type: application/vnd.ms-excel");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename=export.xls");
        header("Content-Transfer-Encoding: binary");

        echo $controllerCountry->exportDataToFile($page);
        break;

    default:
        require 'page.phtml';
}
