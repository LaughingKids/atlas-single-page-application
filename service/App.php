<?php
/**
 * Created by PhpStorm.
 * User: laughingwang
 * Date: 15/6/17
 * Time: 01:43
 */
require_once 'ProductAPI.php';
class App
{
    private $apiInstance = null;
    const API_ROOT_ENDPOINT = 'api';
    const API_PRODUCTS_ENDPOINT = 'products';
    public function __construct()
    {
        $route = explode('/',$_SERVER['REQUEST_URI']);
        if($route[1] != self::API_ROOT_ENDPOINT) {
            header("HTTP/1.1 404 Route not found");
            echo json_encode(null);
        }
        switch ($route[2]) {
            case self::API_PRODUCTS_ENDPOINT:
                $apiInstance = new ProductAPI();
                break;
            default:
                header("HTTP/1.1 404 Route not found");
                echo json_encode(null);
                break;
        }
    }
}