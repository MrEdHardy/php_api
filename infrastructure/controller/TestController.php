<?php
class TestController extends BaseController
{
    /**
     * "/test/list" Endpoint - Get list of users
     */
    public function listAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = ($this->getQueryStringParams());
 
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $testModel = new TestModel();
                $testArtist = new Artist();


                // $result = $testArtist -> AddArtist($arrQueryStringParams);
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
 
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}