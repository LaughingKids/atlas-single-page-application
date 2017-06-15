## How to start the rest server
  1. change server.sh to '755'. chmod 755 server.sh
  2. run bash shell. server will be listen on localhost:8080
  
## Rest Api
  1.Available Route
    /api/products
  2.Allow Method
    GET only
  3.Use query string to change page
  4. Sample Request http://localhost:8080/api/products/?page=1
  5.Limit user methods
    define allow methods
    limit request routes.
    
## Where is the data from?
  Use SourceApiRequest to sent request to ATLAS server. 
  This process looks like access database.
  
## Issues
  1. Fix jquery ajax callback parser error.
  2. change the responce data in UTF-8
  ```
  $data = iconv('UTF-16LE', 'UTF-8', $input);
    if($this->getQueryParameter('callback')) {
        /* deal with jsonp callback function */
        $data = $_GET['callback'] . '(' . $data . ')';
    }
  ```

## Front End
  1. use localstorage to keep each page content in the browser
  2. pagination has been implemented.
  3. Use boostrap CSS framework.
  4. And google map API to locate house poistion.

## TODOS
  1. REST Service
    1) make api request more flexibable, allow user to change region,category etc.
       in other words is to implement a filter function in api.
    2) implement user cookie check machanism to security api.
  2. FRONT end
    introduce React/Angular js into frontend can make application more effective way.
