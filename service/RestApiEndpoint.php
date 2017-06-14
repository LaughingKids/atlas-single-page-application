<?php

/**
 * Created by PhpStorm.
 * User: laughingwang
 * Date: 15/6/17
 * Time: 00:28
 * This Class use as a middleware to check users request
 * before put them into endpoint
 */

class RestApiEndpoint
{
    const BASE_ENDPOINT = '/api';
    /* new endpoint */
    private $endpoint;

    protected $method;

    private $validRequest = false;

    public function setRequestValidation($valid=false) {
        $this->validRequest = $valid;
    }
    public function getRequestValidation(){
        return $this->validRequest;
    }
    public function __construct($endpoints,$allowMethods)
    {
        /* set header values before take response */
        $this->endpoint = self::BASE_ENDPOINT.$endpoint;
        $headerControlMethods = join($allowMethods,' ');
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: ".$headerControlMethods);
        header("Content-Type: application/json");
        /* check user request method */
        $this->setRequestMethod();
        if(in_array($this->method,$allowMethods)) {
            $this->setRequestValidation(true);
        } else {
            $this->_responce(null,405);
            exit();
        }
        /* check user cookie */
    }

    private function endpointCheck(){

    }
    protected function getQueryParameter($name){
        $queryItems = explode('&',$_SERVER['QUERY_STRING']);
        foreach ($queryItems as $queryItem) {
            $query = explode('=',$queryItem);
            if($query[0]==$name){
                return $query[1];
            }
        }
        return null;
    }
    private function setRequestMethod(){
        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                $this->method = '';
            }
        }
    }
    protected function _responce($data,$statusCode=200){
        header("HTTP/1.1 " . $statusCode . " " . $this->_getStatus($statusCode));
        echo $data;
    }
    private function _getStatus($statusCode) {
        switch ($statusCode) {
            case '200': return "OK"; break;
            case '401': return "Unauthorized"; break;
            case '405': return "Method Not Allowed"; break;
            default:
                return "Internal Server Error"; break;
        }
    }
}