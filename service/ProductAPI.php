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
    private $endpoint = '/products';
    private $allowMethods = array('GET');

    public function __construct()
    {
        parent::__construct($this->endpoint,$this->allowMethods);
        $valid = $this->getRequestValidation();
        $data = null;
        switch($this->method){
            case 'GET':
                $data = $this->_getDataViaSourceApi();
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