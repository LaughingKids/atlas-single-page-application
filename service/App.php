<?php
/**
 * Created by PhpStorm.
 * User: laughingwang
 * Date: 15/6/17
 * Time: 01:43
 */
require_once 'ProductAPI.php';
require_once 'UserAPI.php';
class App
{
    private $apiInstance = null;
    public function __construct()
    {
        $route = explode('/',$_SERVER['REQUEST_URI']);
        if($route[1] != 'api') {
            header("HTTP/1.1 404 Route not found");
            echo json_encode(null);
        }
        switch ($route[2]) {
            case 'products':
                $apiInstance = new ProductAPI();
                break;
            case 'users':
                $apiInstance = new UserAPI();
                break;
            default:
                header("HTTP/1.1 404 Route not found");
                echo json_encode(null);
                break;
        }
    }
}