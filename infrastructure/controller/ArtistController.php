<?php
    class ArtistController extends BaseController 
    {
        private readonly Artist $artistModel;
        private readonly array $queryArgsArray;
        private readonly array $requestJsonBody;
        private $strErrorDesc = "";
        private $strErrorHeader = "";
        private $responseData = "";
        
        public function __construct()
        {
            $this->artistModel = new Artist();
            $query = $this->getQueryStringParams();
            $this->queryArgsArray = $query ?? array();
            $body = $this->GetJsonFromRequestBody();
            $this->requestJsonBody = $body ?? array();
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
        
        /**
         * Endpoint ../artists/addArtist
         */
        public function AddArtistAction()
        {
            try 
            {
                $errors = $this->checkServerMethod("POST");
                $this->strErrorDesc = $errors["errorCode"];
                $this->strErrorHeader = $errors["errorHeader"];
                if(!empty($this->strErrorDesc) && !empty($this->strErrorHeader))
                    throw new Error("Method Not Allowed!");
                if(count($this->requestJsonBody) <= 0)
                    throw new Error("No valid JSON was given!");
                $result = $this->artistModel->AddEntity($this->requestJsonBody);
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                // catch Error caused by the controller
                $this->strErrorDesc = empty($this->strErrorDesc) ? " Bad Request!" : "";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = empty($this->strErrorHeader) ? "HTTP/1.1 400 Bad Request" : "HTTP/1.1 405 Method Not Allowed";
            }
            catch (Exception $e)
            {
                // catch errors caused by model
                $this->strErrorDesc = " The JSON cannot be processed. Please check your Object!";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = "HTTP/2.0 422 Unprocessable Entity";
            }
            $this->prepareOutput(array("errorCode" => $this->strErrorDesc, "errorHeader" => $this->strErrorHeader), $this->responseData);
        }

        /**
         * Endpoint ../artists/updateArtist
         */
        public function UpdateArtistAction()
        {
            try 
            {   
                $errors = $this->checkServerMethod("POST");
                $this->strErrorDesc = $errors["errorCode"];
                $this->strErrorHeader = $errors["errorHeader"];
                if(!empty($this->strErrorDesc) && !empty($this->strErrorHeader))
                    throw new Error("Method Not Allowed!");
                if(!isset($this->queryArgsArray["Id"]))
                    throw new Error("No Id given!");
                if(count($this->requestJsonBody) <= 0)
                    throw new Error("No valid JSON was given!");
                $result = $this->artistModel->UpdateEntity($this->queryArgsArray["Id"], $this->requestJsonBody);
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                // catch Error caused by the controller
                $this->strErrorDesc = empty($this->strErrorDesc) ? " Bad Request!" : "";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = empty($this->strErrorHeader) ? "HTTP/1.1 400 Bad Request" : "HTTP/1.1 405 Method Not Allowed";
            }
            catch (Exception $e)
            {
                // catch errors caused by model
                $this->strErrorDesc = " The JSON cannot be processed. Please check your Object!";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = "HTTP/2.0 422 Unprocessable Entity";
            }
            $this->prepareOutput(array("errorCode" => $this->strErrorDesc, "errorHeader" => $this->strErrorHeader), $this->responseData);
        }

        /**
         * Endpoint ../artists/deleteArtist
         */
        public function DeleteArtistAction()
        {
            try 
            {
                $errors = $this->checkServerMethod("DELETE");
                $this->strErrorDesc = $errors["errorCode"];
                $this->strErrorHeader = $errors["errorHeader"];
                if(!empty($this->strErrorDesc) && !empty($this->strErrorHeader))
                    throw new Error("Method Not Allowed!");
                if(!isset($this->queryArgsArray["Id"]) && !isset($this->queryArgsArray["Name"]))
                    throw new Error("Nothing to delete was specified!");
                if(isset($this->queryArgsArray["Id"]))
                {
                    $this->artistModel->DeleteEntity($this->queryArgsArray["Id"]);
                }
                else 
                {
                    $this->artistModel->DeleteArtistByName($this->queryArgsArray["Name"]);    
                }
                $result = array("success" => true);
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                // catch Error caused by the controller
                $this->strErrorDesc = empty($this->strErrorDesc) ? " Bad Request!" : "";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = empty($this->strErrorHeader) ? "HTTP/1.1 400 Bad Request" : "HTTP/1.1 405 Method Not Allowed";
            }
            catch (Exception $e)
            {
                // catch errors caused by model
                $this->strErrorDesc = " Operation failed! Please check Params!";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = "HTTP/2.0 422 Unprocessable Entity";
            }
            $this->prepareOutput(array("errorCode" => $this->strErrorDesc, "errorHeader" => $this->strErrorHeader), $this->responseData);
        }

        /**
         * Endpoint ../artists/getartistbytitle
         */
        public function GetArtistByTitleAction()
        {
            try 
            {
                $errors = $this->checkServerMethod("GET");
                $this->strErrorDesc = $errors["errorCode"];
                $this->strErrorHeader = $errors["errorHeader"];
                if(!empty($this->strErrorDesc) && !empty($this->strErrorHeader))
                    throw new Error("Method Not Allowed!");
                if(!isset($this->queryArgsArray["Id"]) && !isset($this->queryArgsArray["Name"]))
                    throw new Error("Nothing to look for was specified!");
                if (isset($this->queryArgsArray["Id"])) 
                {
                    $result = $this->artistModel->GetArtistsByTitleId($this->queryArgsArray["Id"]);
                } 
                else 
                {
                    $result = $this->artistModel->GetArtistsByTitleName($this->queryArgsArray["Name"]);
                }
                $this->responseData = json_encode($result);
            } catch (Error $e) {
               // catch Error caused by the controller
               $this->strErrorDesc = empty($this->strErrorDesc) ? " Bad Request!" : "";
               $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
               $this->strErrorHeader = empty($this->strErrorHeader) ? "HTTP/1.1 400 Bad Request" : "HTTP/1.1 405 Method Not Allowed";
            }
            catch (Exception $e)
            {
                // catch errors caused by model
                $this->strErrorDesc = " Operation failed! Please check Params!";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = "HTTP/2.0 422 Unprocessable Entity";
            }
            $this->prepareOutput(array("errorCode" => $this->strErrorDesc, "errorHeader" => $this->strErrorHeader), $this->responseData);
        }

        /**
         * Endpoint ../artists/gettitlecollectionIdsbyartistandtitle
         */
        public function GetTitleCollectionIdsByArtistAndTitleAction()
        {
            try 
            {
                $errors = $this->checkServerMethod("GET");
                $this->strErrorDesc = $errors["errorCode"];
                $this->strErrorHeader = $errors["errorHeader"];
                if(!empty($this->strErrorDesc) && !empty($this->strErrorHeader))
                    throw new Error("Method Not Allowed!");
                if(count($this->requestJsonBody) <= 0)
                    throw new Error("No valid JSON was given!");
                if(isset($this->requestJsonBody["TitleId"]) && isset($this->requestJsonBody["ArtistId"]))
                {
                    $result = $this->artistModel
                    ->GetTitleCollectionIdByArtistIdAndTitleId($this->requestJsonBody["TitleId"], $this->requestJsonBody["ArtistId"]);
                }
                elseif(isset($this->requestJsonBody["TitleName"]) && isset($this->requestJsonBody["ArtistName"]))
                {
                    $result = $this->artistModel
                    ->GetTitleCollectionIdByArtistNameAndTitleName($this->requestJsonBody["TitleName"], $this->requestJsonBody["ArtistName"]);
                }
                else
                {
                    throw new Error("JSONs cannot have mixed Attributes!");
                }
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                // catch Error caused by the controller
                $this->strErrorDesc = empty($this->strErrorDesc) ? " Bad Request!" : "";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = empty($this->strErrorHeader) ? "HTTP/1.1 400 Bad Request" : "HTTP/1.1 405 Method Not Allowed";
            }
            catch (Exception $e)
            {
                // catch errors caused by model
                $this->strErrorDesc = " The JSON cannot be processed. Please check your Object!";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = "HTTP/2.0 422 Unprocessable Entity";
            }
            $this->prepareOutput(array("errorCode" => $this->strErrorDesc, "errorHeader" => $this->strErrorHeader), $this->responseData);
        }

        /**
         * Endpoint ../artists/addnewtitlecollectionentry
         */
        public function AddNewTitleCollectionEntryAction()
        {
            try 
            {
                $errors = $this->checkServerMethod("PUT");
                $this->strErrorDesc = $errors["errorCode"];
                $this->strErrorHeader = $errors["errorHeader"];
                if(!empty($this->strErrorDesc) && !empty($this->strErrorHeader))
                    throw new Error("Method Not Allowed!");
                if(count($this->requestJsonBody) <= 0)
                    throw new Error("No valid JSON was given!");
                if(isset($this->requestJsonBody["TitleId"]) && isset($this->requestJsonBody["ArtistId"]))
                {
                    $result = $this->artistModel
                    ->AddNewTitleCollectionEntry($this->requestJsonBody["TitleId"], $this->requestJsonBody["ArtistId"]);
                }
                else
                {
                    throw new Error("JSON is invalid!");
                }
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                // catch Error caused by the controller
                $this->strErrorDesc = empty($this->strErrorDesc) ? " Bad Request!" : "";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = empty($this->strErrorHeader) ? "HTTP/1.1 400 Bad Request" : "HTTP/1.1 405 Method Not Allowed";
            }
            catch (Exception $e)
            {
                // catch errors caused by model
                $this->strErrorDesc = " The JSON cannot be processed. Please check your Object!";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = "HTTP/2.0 422 Unprocessable Entity";
            }
            $this->prepareOutput(array("errorCode" => $this->strErrorDesc, "errorHeader" => $this->strErrorHeader), $this->responseData);
        }

         /**
         * Endpoint ../artists/updatetitlecollectionentry
         */
        public function UpdateTitleCollectionEntryAction()
        {
            try 
            {
                $errors = $this->checkServerMethod("POST");
                $this->strErrorDesc = $errors["errorCode"];
                $this->strErrorHeader = $errors["errorHeader"];
                if(!empty($this->strErrorDesc) && !empty($this->strErrorHeader))
                    throw new Error("Method Not Allowed!");
                if(!isset($this->queryArgsArray["Id"]))
                    throw new Error("Id is required!");
                if(count($this->requestJsonBody) <= 0)
                    throw new Error("No valid JSON was given!");
                if(isset($this->requestJsonBody["TitleId"]) && isset($this->requestJsonBody["ArtistId"]))
                {
                    $result = $this->artistModel
                    ->UpdateTitleCollectionEntry($this->queryArgsArray["Id"], $this->requestJsonBody["TitleId"], $this->requestJsonBody["ArtistId"]);
                }
                else
                {
                    throw new Error("JSON is invalid!");
                }
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                // catch Error caused by the controller
                $this->strErrorDesc = empty($this->strErrorDesc) ? " Bad Request!" : "";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = empty($this->strErrorHeader) ? "HTTP/1.1 400 Bad Request" : "HTTP/1.1 405 Method Not Allowed";
            }
            catch (Exception $e)
            {
                // catch errors caused by model
                $this->strErrorDesc = " The JSON cannot be processed. Please check your Object!";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = "HTTP/2.0 422 Unprocessable Entity";
            }
            $this->prepareOutput(array("errorCode" => $this->strErrorDesc, "errorHeader" => $this->strErrorHeader), $this->responseData);
        }

         /**
         * Endpoint ../artists/deletetitlecollectionentry
         */
        public function DeleteTitleCollectionEntryAction()
        {
            try 
            {
                $errors = $this->checkServerMethod("DELETE");
                $this->strErrorDesc = $errors["errorCode"];
                $this->strErrorHeader = $errors["errorHeader"];
                if(!empty($this->strErrorDesc) && !empty($this->strErrorHeader))
                    throw new Error("Method Not Allowed!");
                if(isset($this->queryArgsArray["Id"]))
                {
                    $this->artistModel->DeleteTitleCollectionEntryById($this->queryArgsArray["Id"]);
                }
                elseif(count($this->requestJsonBody) > 0 && isset($this->requestJsonBody["TitleId"]) && isset($this->requestJsonBody["ArtistId"]))
                {
                    $this->artistModel->DeleteTitleCollectionEntryByArtistIdAndTitleId($this->requestJsonBody["TitleId"], $this->requestJsonBody["ArtistId"]);
                }
                else
                {
                    throw new Error("Id in Query or JSON with TitleId, ArtistId must be set!");
                }
                $result = array("successfull" => true);
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                // catch Error caused by the controller
                $this->strErrorDesc = empty($this->strErrorDesc) ? " Bad Request!" : "";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = empty($this->strErrorHeader) ? "HTTP/1.1 400 Bad Request" : "HTTP/1.1 405 Method Not Allowed";
            }
            catch(Exception $e)
            {
                // catch errors caused by model
                $this->strErrorDesc = " The JSON cannot be processed. Please check your Object!";
                $this->strErrorDesc = $e->getMessage().$this->strErrorDesc;
                $this->strErrorHeader = "HTTP/2.0 422 Unprocessable Entity";
            }
            $this->prepareOutput(array("errorCode" => $this->strErrorDesc, "errorHeader" => $this->strErrorHeader), $this->responseData);
        }
        // more Actions to come ...
    }
?>
