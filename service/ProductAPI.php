<?php

/**
 * Created by PhpStorm.
 * User: laughingwang
 * Date: 14/6/17
 * Time: 23:34
 */
require_once 'SourceApiRequest.php';
require_once 'RestApiEndpoint.php';
class ProductAPI extends RestApiEndpoint
{
    private $allowMethods = array('GET');

    public function __construct()
    {
        parent::__construct($this->allowMethods);
        $data = null;
        switch($this->method){
            case 'GET':
                $input = $this->_getDataViaSourceApi();
                $data = iconv('UTF-16LE', 'UTF-8', $input);
                if($this->getQueryParameter('callback')) {
                    /* deal with jsonp callback function */
                    $data = $_GET['callback'] . '(' . $data . ')';
                }

                break;
            default:
                break;
        }
        $this->_responce($data,200);
    }

    private function _getDataViaSourceApi() {
        $pageNumber = $this->getQueryParameter('page');
        if($pageNumber == null){
            $pageNumber = 1;
        }
        $backend_api_request = new SourceApiRequest();
        $responce = $backend_api_request->doGetRequest($pageNumber);
        return $responce;
    }
}