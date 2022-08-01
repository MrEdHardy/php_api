<?php
enum HttpStatusCodesEnum : string
{
    case OK = "HTTP/1.1 200 OK";
    case BadRequest = "HTTP/1.1 400 Bad Request";
    case NotFound = "HTTP/1.1 404 Not Found";
    case NotAllowed = "HTTP/1.1 405 Method Not Allowed";
    case UnprocessableEntity = "HTTP/2.0 422 Unprocessable Entity";
    case InternalServerError = "HTTP/1.1 500 Internal Server Error";
}

enum RequiredFieldTypes : int
{
    case Id = 1;
    case JSON = 2;
    case IdAndJSON = 1024;
    case IdOrName = 2048;
    case IdOrJSON = 65536;
}

enum ControllerErrors : string
{
    case IdMissing = "Id is required!";
    case NoValidJSON = "No valid JSON was given!";
    case NoValidJSONOrId = "valid Id or JSON is required!";
    case NoValidJSONAndId = "valid Id & JSON is required!";
    case NotAllowed = "Method Not Allowed!";
    case NoIdOrName = "Id or Name are required!";
}

class BaseController
{
    protected readonly array $queryArgsArray;
    protected readonly array $requestJsonBody;
    protected bool $correctServerMethod;
    protected $strErrorDesc = "";
    protected $strErrorHeader = "";
    protected $responseData = "";
    protected RequiredFieldTypes $requiredFields;

    public function __construct()
    {
        $query = $this->getQueryStringParams();
        $this->queryArgsArray = $query ?? array();
        $body = $this->GetJsonFromRequestBody();
        $this->requestJsonBody = $body ?? array();
        $this->correctServerMethod = true;
    }

    /**
     * __call magic method.
     */
    public function __call($name, $arguments)
    {
        $this->sendOutput(json_encode(array("error" => "Your call target is invalid!")), array(HttpStatusCodesEnum::NotFound->value));
    }
 
    /**
     * Get querystring params.
     * 
     * @return array
     */
    private function getQueryStringParams()
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

    /**
     * Prepares data to be sent to user
     */
    protected function prepareOutput()
    {
        if (empty($this->strErrorHeader)) {
            $this->sendOutput(
                $this->responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $this->strErrorDesc)), 
                array('Content-Type: application/json', $this->strErrorHeader)
            );
        }
    }

    /**
     * @return array with Error Descriptions if server method isn't the desired method; otherwise array with empty elements
     */
    private function checkServerMethod(string $expected)
    {
        $errDesc = "";
        $errHeader = "";
        if(strcasecmp($_SERVER["REQUEST_METHOD"], $expected) != 0)
        {
            $errDesc = "Method not supported";
            $errHeader = HttpStatusCodesEnum::NotAllowed->value;
        }
        $this->strErrorDesc = $errDesc;
        $this->strErrorHeader = $errHeader;
    }

    /**
     * Will try to parse JSON Body to associative array
     * @return array|null will return associative array or null
     */
    private function GetJsonFromRequestBody() : array | null
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

    /**
     * Checks whether the the server method was correct or throw error with status 405
     * @param string $method the required server method 
     */
    protected function validateServerMethod(string $method)
    {
        $this->checkServerMethod($method);
        if(!empty($this->strErrorDesc) && !empty($this->strErrorHeader))
        {
            $this->correctServerMethod = false;
            throw new Error(ControllerErrors::NotAllowed->value);
        }
    }

    /**
     * Sets the http statuscode and error description
     * @param string $stackTrace the thrown error message
     * @param string $errorBody the additional error message
     * @param string $errorHeader the http status code
     */
    protected function setErrorMsg(string $stackTrace, string $errorBody, string $errorHeader)
    {
        if(!$this->correctServerMethod)
        {
            $this->strErrorDesc = ControllerErrors::NotAllowed->value;
            $this->strErrorHeader = HttpStatusCodesEnum::NotAllowed->value;
        }
        else
        {
            $this->strErrorDesc = $stackTrace.$errorBody;
            $this->strErrorHeader = $errorHeader;
        }
    }

    /**
     * Checks all the necessary fields and throws an error if it's not set
     * @param RequiredFieldTypes $fields sets the requiredFields property in the BaseController
     */
    protected function checkParams(RequiredFieldTypes $fields)
    {
        $this->requiredFields = $fields;
        if($this->requiredFields === RequiredFieldTypes::Id)
        {
            if(!isset($this->queryArgsArray["Id"]))
            {
                $this->strErrorHeader = HttpStatusCodesEnum::BadRequest->value;
                throw new Error(ControllerErrors::IdMissing->value);
            }
        }
        elseif($this->requiredFields === RequiredFieldTypes::JSON)
        {
            if(count($this->requestJsonBody) <= 0)
            {
                $this->strErrorHeader = HttpStatusCodesEnum::BadRequest->value;
                throw new Error(ControllerErrors::NoValidJSON->value);
            }
        }
        elseif($this->requiredFields === RequiredFieldTypes::IdAndJSON)
        {
            if(!isset($this->queryArgsArray["Id"]) || count($this->requestJsonBody) <= 0)
            {
                $this->strErrorHeader = HttpStatusCodesEnum::BadRequest->value;
                throw new Error(ControllerErrors::NoValidJSONAndId->value);
            }
        }
        elseif($this->requiredFields === RequiredFieldTypes::IdOrJSON)
        {
            if(!isset($this->queryArgsArray["Id"]) && count($this->requestJsonBody) <= 0)
            {
                $this->strErrorHeader = HttpStatusCodesEnum::BadRequest->value;
                throw new Error(ControllerErrors::NoValidJSONOrId->value);
            }
        }
        elseif($this->requiredFields === RequiredFieldTypes::IdOrName)
        {
            if(!isset($this->queryArgsArray["Id"]) && !isset($this->queryArgsArray["Name"]))
            {
                $this->strErrorHeader = HttpStatusCodesEnum::BadRequest->value;
                throw new Error(ControllerErrors::NoIdOrName->value);
            }
        }
    }
}