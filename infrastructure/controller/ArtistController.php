<?php
    class ArtistController extends BaseController 
    {
        private readonly Artist $artistModel;
        
        public function __construct()
        {
            $this->artistModel = new Artist();
            parent::__construct();
        }

        /**
         * Endpoint ../artists/getAllArtists
         */
        public function GetAllArtistsAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                // Execute Query
                $result = $this->artistModel->GetAllEntities();
                // Encode Result to JSON
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                $this->setErrorMsg($e->getMessage(), "", $this->strErrorHeader);
            }
            catch (Exception $e)
            {
                $this->setErrorMsg($e->getMessage(), "Something went wrong", HttpStatusCodesEnum::InternalServerError->value);
            }

            // sends either an error or a result back to the user
            $this->prepareOutput();
        }

        /**
         * Endpoint ../artists/getArtistById
         */
        public function GetArtistByIdAction()
        {            
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::Id);
                $result = $this->artistModel->GetEntityById($this->queryArgsArray["Id"]);
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                // catch errors caused by the controller
                $this->setErrorMsg($e->getMessage(), "", $this->strErrorHeader);
            } 
            catch (Exception $e) 
            {
                $this->setErrorMsg($e->getMessage(), " Something went wrong!", HttpStatusCodesEnum::InternalServerError->value);
            }

            $this->prepareOutput();
        }
        
        /**
         * Endpoint ../artists/addArtist
         */
        public function AddArtistAction()
        {
            try 
            {
                $this->validateServerMethod("PUT");
                $this->checkParams(RequiredFieldTypes::JSON);
                $result = $this->artistModel->AddEntity($this->requestJsonBody);
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                // catch errors caused by the controller
                $this->setErrorMsg($e->getMessage(), "", $this->strErrorHeader);
            }
            catch (Exception $e)
            {
                // catch errors caused by model
                $errorBody = $e->getMessage()." The JSON cannot be processed. Please check your Object!";
                $this->setErrorMsg($e->getMessage(), $errorBody, HttpStatusCodesEnum::UnprocessableEntity->value);
            }
            $this->prepareOutput();
        }

        /**
         * Endpoint ../artists/updateArtist
         */
        public function UpdateArtistAction()
        {
            try 
            {   
                $this->validateServerMethod("POST");
                $this->checkParams(RequiredFieldTypes::IdAndJSON);
                $result = $this->artistModel->UpdateEntity($this->queryArgsArray["Id"], $this->requestJsonBody);
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                $this->setErrorMsg($e->getMessage(), "", $this->strErrorHeader);
            }
            catch (Exception $e)
            {
                // catch errors caused by model
                $errorBody = $e->getMessage()." The JSON cannot be processed. Please check your Object!";
                $this->setErrorMsg($e->getMessage(), $errorBody, HttpStatusCodesEnum::UnprocessableEntity->value);
            }
            $this->prepareOutput();
        }

        /**
         * Endpoint ../artists/deleteArtist
         */
        public function DeleteArtistAction()
        {
            try 
            {
                $this->validateServerMethod("DELETE");
                $this->checkParams(RequiredFieldTypes::IdOrName);
                if(isset($this->queryArgsArray["Id"]))
                {
                    $result = $this->artistModel->DeleteEntity($this->queryArgsArray["Id"]);
                }
                else 
                {
                    $result = $this->artistModel->DeleteArtistByName($this->queryArgsArray["Name"]);    
                }
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                $this->setErrorMsg($e->getMessage(), "", $this->strErrorHeader);
            }
            catch (Exception $e)
            {
                // catch errors caused by model
                $errorBody = $e->getMessage()." Operation Failed!";
                $this->setErrorMsg($e->getMessage(), $errorBody, HttpStatusCodesEnum::UnprocessableEntity->value);
            }
            $this->prepareOutput();
        }

        /**
         * Endpoint ../artists/getartistbytitle
         */
        public function GetArtistByTitleAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::IdOrName);
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
                $this->setErrorMsg($e->getMessage(), "", $this->strErrorHeader);
            }
            catch (Exception $e)
            {
                // catch errors caused by model
                $errorBody = $e->getMessage()." Operation Failed!";
                $this->setErrorMsg($e->getMessage(), $errorBody, HttpStatusCodesEnum::UnprocessableEntity->value);
            }
            $this->prepareOutput();
        }

        /**
         * Endpoint ../artists/gettitlecollectionIdsbyartistandtitle
         */
        public function GetTitleCollectionIdsByArtistAndTitleAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::JSON);
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
                $this->setErrorMsg($e->getMessage(), "", empty($this->strErrorHeader) ? HttpStatusCodesEnum::BadRequest->value : $this->strErrorHeader);
            }
            catch (Exception $e)
            {
                // catch errors caused by model
                $errorBody = $e->getMessage()." The JSON cannot be processed. Please check your Object!";
                $this->setErrorMsg($e->getMessage(), $errorBody, HttpStatusCodesEnum::UnprocessableEntity->value);
            }
            $this->prepareOutput();
        }

        /**
         * Endpoint ../artists/addnewtitlecollectionentry
         */
        public function AddNewTitleCollectionEntryAction()
        {
            try 
            {
                $this->validateServerMethod("PUT");
                $this->checkParams(RequiredFieldTypes::JSON);
                $result = $this->artistModel
                    ->AddNewTitleCollectionEntry($this->requestJsonBody);
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                // catch Error caused by the controller
                $this->setErrorMsg($e->getMessage(), "", empty($this->strErrorHeader) ? HttpStatusCodesEnum::BadRequest->value : $this->strErrorHeader);
            }
            catch (Exception $e)
            {
                // catch errors caused by model
                $errorBody = " The JSON cannot be processed. Please check your Object!";
                $this->setErrorMsg($e->getMessage(), $errorBody, HttpStatusCodesEnum::UnprocessableEntity->value);
            }
            $this->prepareOutput();
        }

         /**
         * Endpoint ../artists/updatetitlecollectionentry
         */
        public function UpdateTitleCollectionEntryAction()
        {
            try 
            {
                $this->validateServerMethod("POST");
                $this->checkParams(RequiredFieldTypes::IdAndJSON);
                $result = $this->artistModel
                    ->UpdateTitleCollectionEntry($this->queryArgsArray["Id"], $this->requestJsonBody);
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                // catch Error caused by the controller
                $this->setErrorMsg($e->getMessage(), "", empty($this->strErrorHeader) ? HttpStatusCodesEnum::BadRequest->value : $this->strErrorHeader);
            }
            catch (Exception $e)
            {
                // catch errors caused by model
                $errorBody = " The JSON cannot be processed. Please check your Object!";
                $this->setErrorMsg($e->getMessage(), $errorBody, HttpStatusCodesEnum::UnprocessableEntity->value);
            }
            $this->prepareOutput();
        }

         /**
         * Endpoint ../artists/deletetitlecollectionentry
         */
        public function DeleteTitleCollectionEntryAction()
        {
            try 
            {
                $this->validateServerMethod("DELETE");
                $this->checkParams(RequiredFieldTypes::IdOrJSON);
                if(isset($this->queryArgsArray["Id"]))
                {
                    $result = $this->artistModel->DeleteTitleCollectionEntryById($this->queryArgsArray["Id"]);
                }
                elseif(count($this->requestJsonBody) > 0 && isset($this->requestJsonBody["TitleId"]) && isset($this->requestJsonBody["ArtistId"]))
                {
                    $result = $this->artistModel->DeleteTitleCollectionEntryByArtistIdAndTitleId($this->requestJsonBody["TitleId"], $this->requestJsonBody["ArtistId"]);
                }
                else
                {
                    throw new Error("Id in Query or JSON with TitleId, ArtistId must be set!");
                }
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                // catch Error caused by the controller
                $this->setErrorMsg($e->getMessage(), "", empty($this->strErrorHeader) ? HttpStatusCodesEnum::BadRequest->value : $this->strErrorHeader);
            }
            catch(Exception $e)
            {
                // catch errors caused by model
                $errorBody = $e->getMessage()." The JSON cannot be processed. Please check your Object!";
                $this->setErrorMsg($e->getMessage(), $errorBody, HttpStatusCodesEnum::UnprocessableEntity->value);
            }
            $this->prepareOutput();
        }
    }
?>
