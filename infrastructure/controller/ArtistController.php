<?php
    class ArtistController extends BaseController 
    {
        private readonly Artist $artistModel;
        private readonly array $queryArgsArray;
        private $strErrorDesc = "";
        private $strErrorHeader = "";
        private $responseData = "";
        
        public function __construct()
        {
            $this->artistModel = new Artist();
            $query = $this->getQueryStringParams();
            $this->queryArgsArray = $query ?? array();
        }

        /**
         * Endpoint ../artists/getAllArtists
         */
        public function GetAllArtistsAction()
        {
            $errors = $this->checkServerMethod("GET");
            $this->strErrorDesc = $errors["errorCode"];
            $this->strErrorHeader = $errors["errorHeader"];
            try 
                {
                    // Execute Query
                    $result = $this->artistModel->GetAllEntities();
                    // Encode Result to JSON
                    $this->responseData = json_encode($result);

                } catch (Error $e) {
                    $this->strErrorDesc = $e->getMessage()."\n Error 500: Something went wrong!";
                    $this->strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }

            // sends either an error or a result back to the user
            $this->prepareOutput(array("errorCode" => $this->strErrorDesc, "errorHeader" => $this->strErrorHeader), $this->responseData);
        }

        /**
         * Endpoint ../artists/getArtistById
         */
        public function GetArtistByIdAction()
        {            
            $errors = $this->checkServerMethod("GET");
            $this->strErrorDesc = $errors["errorCode"];
            $this->strErrorHeader = $errors["errorHeader"];
            try 
                {
                    // if Id isn't set then throw error
                    if(!isset($this->queryArgsArray["Id"]))
                        throw new Error("No Id given!");
                    $result = $this->artistModel->GetEntityById($this->queryArgsArray["Id"]);
                    $this->responseData = json_encode($result);

                } catch (Error $e) {
                    $this->strErrorDesc = !isset($this->queryArgsArray["Id"]) ? " Bad Request!" : " Something went wrong!";
                    $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                    $this->strErrorHeader = !isset($this->queryArgsArray["Id"]) ? "HTTP/1.1 400 Bad Request" : "HTTP/1.1 500 Internal Server Error";
                }
            $this->prepareOutput(array("errorCode" => $this->strErrorDesc, "errorHeader" => $this->strErrorHeader), $this->responseData);
        }

        // more Actions to come ...
    }
?>
