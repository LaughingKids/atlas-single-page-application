<?php
/**
 * Created by PhpStorm.
 * User: laughingwang
 * Date: 14/6/17
 * Time: 20:00
 */
class SourceApiRequest
{
    /* ATDW API Host should be protected */
    const ATDW_API_HOST = 'http://atlas.atdw-online.com.au/api/atlas';
    /* products request endpoint */
    const ATDW_API_PRODUCT_ROUTE = "/products";
    /*
     * regions request endpoint
     * in the task description
     * our service focus but not only on "Blue Mountains"->id=29000008;code=BMT
     * so we need to fix the region request detail.
     * More regions can be get via GET request to ATDW API '/regions' endpoint
     * e.g. GET 'http://atlas.atdw-online.com.au/api/atlas/regions'
     */
    const ATDW_API_REQUEST_TARGET_REGION = "rg=BMT";
    /*
     * Limit target product category to accommodation whose id equals to 'ACCOMM'
     * More category can be get via GET request to ATDW API '/categories' endpoint
     * e.g. GET 'http://atlas.atdw-online.com.au/api/atlas/categories'
     */
    const ATDW_API_REQUEST_TARGET_CAT = "cats=ACCOMM";
    /*
     * ATDW data should return in json format
     */
    const ATDW_API_RESPONSE_DATA_FORMAT = "out=json";

    /* ATDW API KEY */
    const ATDW_API_KEY = "key=2015201520159";

    /* Only Allow GET request */
    const ATDW_ALLOWED_ACTION = "get";

    /* Default post per page amount is 10*/
    const ATDW_PAGE_SIZE = "size=10";

    /* Default page number parameter */
    const ATDW_PAGE_NUMBER = "pge=";

    public $requestURL;

    /* Default Constructor Return all parameters as default */
    public function __construct(){
        $params = [ self::ATDW_API_KEY,
                    self::ATDW_API_REQUEST_TARGET_CAT,
                    self::ATDW_API_REQUEST_TARGET_REGION,
                    self::ATDW_API_RESPONSE_DATA_FORMAT,
                    self::ATDW_PAGE_SIZE];
        $query = join('&',$params);
        $this->requestURL = self::ATDW_API_HOST.
                         self::ATDW_API_PRODUCT_ROUTE.'?'.$query;
    }
    /*
     * @param: current page number, default number is 1
     * return: return a paged request url
     */
    private function pagedRequest($page){
        $movedPage = '&'.self::ATDW_PAGE_NUMBER.$page;
        return $this->requestURL.$movedPage;
    }
    public function doGetRequest($page = 1){
        $url = $this->pagedRequest($page);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        /* keep return data in variable but output directly */
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }
}