<?php
class BaseController
{
    /**
     * __call magic method.
     */
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }
 
    /**
     * @deprecated not used anymore, due for removal
     * 
     * Get URI elements.
     * 
     * @return array
     */
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );
 
        return $uri;
    }
 
    /**
     * Get querystring params.
     * 
     * @return array
     */
    protected function getQueryStringParams()
    {
        $queryString = null;
        if(isset($_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $query);
            $queryString = $query; 
        }
        return $queryString;
    }
 
    /**
     * Send API output.
     *
     * @param mixed  $data
     * @param string $httpHeader
     */
    private function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
 
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
 
        echo $data;
        exit;
    }

    protected function prepareOutput(array $errorEntity, $responseData)
    {
        if (!$errorEntity["errorCode"]) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $errorEntity["errorCode"])), 
                array('Content-Type: application/json', $errorEntity["errorHeader"])
            );
        }
    }

    /**
     * @return array with Error Descriptions if server method isn't the desired method; otherwise array with empty elements
     */
    protected function checkServerMethod(string $expected) : array
    {
        $errDesc = "";
        $errHeader = "";
        if(strcasecmp($_SERVER["REQUEST_METHOD"], $expected) != 0)
        {
            $errDesc = "Error 422: Method not supported";
            $errHeader = "HTTP/1.1 422 Unprocessable Entity";
        }
        return array("errorCode" => $errDesc, "errorHeader" => $errHeader);
    }

    /**
     * Will try to parse JSON Body to associative array
     * @return array|null will return associative array or null
     */
    protected function GetJsonFromRequestBody() : array | null
    {
        $request_body = file_get_contents("php://input");
        $jsonObject = json_decode($request_body);
        if($jsonObject === null)
            return $jsonObject;

        $data = array();
        foreach ($jsonObject as $key => $value) 
            $data[$key] = $value;
        return $data;
    }
}