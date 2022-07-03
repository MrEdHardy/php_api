<?php
class TestController extends BaseController
{
    /**
     * "/test/list" Endpoint - Get list of Artists
     */
    public function listAction()
    {
        $strErrorDesc = "";
        $strErrorHeader = "";
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = ($this->getQueryStringParams());
 
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $testModel = new TestModel();
                $arrArtists = $testModel->getAllArtists();
                $responseData = json_encode($arrArtists);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        
        // sends Output
        $this->prepareOutput(array("errorCode" => $strErrorDesc, "errorHeader" => $strErrorHeader), $responseData);
    }
}