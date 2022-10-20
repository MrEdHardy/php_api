<?php
    class TitleController extends BaseController
    {
        private readonly Title $titleModel;

        public function __construct() 
        {
            $this->titleModel = new Title();
            parent::__construct();
        }

        /**
         * Endpoint ../titles/getalltitles
         */
        public function GetAllTitlesAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $result = $this->titleModel->GetAllEntities();
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                $this->setErrorMsg($e->getMessage(), "", $this->strErrorHeader);
            }
            catch (Exception $e)
            {
                $this->setErrorMsg($e->getMessage(), " Something went wrong!", HttpStatusCodesEnum::InternalServerError->value);
            }

            $this->prepareOutput();
        }

        /**
         * Endpoint ../titles/gettitlebyid
         */
        public function GetTitleByIdAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::Id);
                $result = $this->titleModel->GetEntityById($this->queryArgsArray["Id"]);
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                $this->setErrorMsg($e->getMessage(), "", $this->strErrorHeader);
            }
            catch (Exception $e)
            {
                $this->setErrorMsg($e->getMessage(), " Something went wrong!", HttpStatusCodesEnum::InternalServerError->value);
            }

            $this->prepareOutput();
        }

        /**
         * Endpoint ../titles/addtitle
         */
        public function AddTitleAction()
        {
            try 
            {
                $this->validateServerMethod("PUT");
                $this->checkParams(RequiredFieldTypes::JSON);
                $result = $this->titleModel->AddEntity($this->requestJsonBody);
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                $this->setErrorMsg($e->getMessage(), "", $this->strErrorHeader);
            }
            catch (Exception $e)
            {
                $this->setErrorMsg($e->getMessage(), " Something went wrong!", HttpStatusCodesEnum::InternalServerError->value);
            }

            $this->prepareOutput();
        }

        /**
         * Endpoint ../titles/updatetitle
         */
        public function UpdateTitleAction()
        {
            try 
            {
                $this->validateServerMethod("POST");
                $this->checkParams(RequiredFieldTypes::IdAndJSON);
                $result = $this->titleModel->UpdateEntity($this->queryArgsArray["Id"], $this->requestJsonBody);
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                $this->setErrorMsg($e->getMessage(), "", $this->strErrorHeader);
            }
            catch (Exception $e)
            {
                $this->setErrorMsg($e->getMessage(), " Something went wrong!", HttpStatusCodesEnum::InternalServerError->value);
            }

            $this->prepareOutput();
        }

        /**
         * Endpoint ../titles/deletetitle
         */
        public function DeleteTitleAction()
        {
            try 
            {
                $this->validateServerMethod("DELETE");
                $this->checkParams(RequiredFieldTypes::IdOrName);
                if(isset($this->queryArgsArray["Id"]))
                {
                    $this->titleModel->DeleteEntity($this->queryArgsArray["Id"]);
                }
                else 
                {
                    $this->titleModel->DeleteTitlesByName($this->queryArgsArray["Name"]);    
                }
                $result = array("successful" => true);
                $this->responseData = json_encode($result);
            } catch (Error $e) {
                $this->setErrorMsg($e->getMessage(), "", $this->strErrorHeader);
            }
            catch (Exception $e)
            {
                $this->setErrorMsg($e->getMessage(), " Something went wrong!", HttpStatusCodesEnum::InternalServerError->value);
            }

            $this->prepareOutput();
        }

        // /**
        //  * Endpoint ../titles/gettitlecollectionIdsbyartistandtitle
        //  */
        // public function GetTitleCollectionIdsByArtistAndTitleAction()
        // {
        //     try 
        //     {
        //         $this->validateServerMethod("GET");
        //         $this->checkParams(RequiredFieldTypes::JSON);
        //         if(isset($this->requestJsonBody["TitleId"]) && isset($this->requestJsonBody["ArtistId"]))
        //         {
        //             $result = $this->titleModel
        //             ->GetTitleCollectionIdByArtistIdAndTitleId($this->requestJsonBody["TitleId"], $this->requestJsonBody["ArtistId"]);
        //         }
        //         elseif(isset($this->requestJsonBody["TitleName"]) && isset($this->requestJsonBody["ArtistName"]))
        //         {
        //             $result = $this->titleModel
        //             ->GetTitleCollectionIdByArtistNameAndTitleName($this->requestJsonBody["TitleName"], $this->requestJsonBody["ArtistName"]);
        //         }
        //         else
        //         {
        //             throw new Error("JSONs cannot have mixed Attributes!");
        //         }
        //         $this->responseData = json_encode($result);
        //     } catch (Error $e) {
        //         $this->setErrorMsg($e->getMessage(), "", empty($this->strErrorHeader) ? HttpStatusCodesEnum::BadRequest->value : $this->strErrorHeader);
        //     }
        //     catch (Exception $e)
        //     {
        //         $errorBody = $e->getMessage()." The JSON cannot be processed. Please check your Object!";
        //         $this->setErrorMsg($e->getMessage(), $errorBody, HttpStatusCodesEnum::UnprocessableEntity->value);
        //     }
        //     $this->prepareOutput();
        // }

        // /**
        //  * Endpoint ../titles/addnewtitlecollectionentry
        //  */
        // public function AddNewTitleCollectionEntryAction()
        // {
        //     try 
        //     {
        //         $this->validateServerMethod("PUT");
        //         $this->checkParams(RequiredFieldTypes::JSON);
        //         if(isset($this->requestJsonBody["TitleId"]) && isset($this->requestJsonBody["ArtistId"]))
        //         {
        //             $result = $this->titleModel
        //             ->AddNewTitleCollectionEntry($this->requestJsonBody["TitleId"], $this->requestJsonBody["ArtistId"]);
        //         }
        //         else
        //         {
        //             throw new Error("JSON is invalid!");
        //         }
        //         $this->responseData = json_encode($result);
        //     } catch (Error $e) {
        //         $this->setErrorMsg($e->getMessage(), "", empty($this->strErrorHeader) ? HttpStatusCodesEnum::BadRequest->value : $this->strErrorHeader);
        //     }
        //     catch (Exception $e)
        //     {
        //         $errorBody = $e->getMessage()." The JSON cannot be processed. Please check your Object!";
        //         $this->setErrorMsg($e->getMessage(), $errorBody, HttpStatusCodesEnum::UnprocessableEntity->value);
        //     }
        //     $this->prepareOutput();
        // }

        // /**
        //  * Endpoint ../titles/updatetitlecollectionentry
        //  */
        // public function UpdateTitleCollectionEntryAction()
        // {
        //     try 
        //     {
        //         $this->validateServerMethod("POST");
        //         $this->checkParams(RequiredFieldTypes::IdAndJSON);
        //         if(isset($this->requestJsonBody["TitleId"]) && isset($this->requestJsonBody["ArtistId"]))
        //         {
        //             $result = $this->titleModel
        //             ->UpdateTitleCollectionEntry($this->queryArgsArray["Id"], $this->requestJsonBody["TitleId"], $this->requestJsonBody["ArtistId"]);
        //         }
        //         else
        //         {
        //             throw new Error("JSON is invalid!");
        //         }
        //         $this->responseData = json_encode($result);
        //     } catch (Error $e) {
        //         $this->setErrorMsg($e->getMessage(), "", empty($this->strErrorHeader) ? HttpStatusCodesEnum::BadRequest->value : $this->strErrorHeader);
        //     }
        //     catch (Exception $e)
        //     {
        //         $errorBody = $e->getMessage()." The JSON cannot be processed. Please check your Object!";
        //         $this->setErrorMsg($e->getMessage(), $errorBody, HttpStatusCodesEnum::UnprocessableEntity->value);
        //     }
        //     $this->prepareOutput();
        // }

        //  /**
        //  * Endpoint ../titles/deletetitlecollectionentry
        //  */
        // public function DeleteTitleCollectionEntryAction()
        // {
        //     try 
        //     {
        //         $this->validateServerMethod("DELETE");
        //         $this->checkParams(RequiredFieldTypes::IdOrJSON);
        //         if(isset($this->queryArgsArray["Id"]))
        //         {
        //             $this->titleModel->DeleteTitleCollectionEntryById($this->queryArgsArray["Id"]);
        //         }
        //         elseif(count($this->requestJsonBody) > 0 && isset($this->requestJsonBody["TitleId"]) && isset($this->requestJsonBody["ArtistId"]))
        //         {
        //             $this->titleModel->DeleteTitleCollectionEntryByArtistIdAndTitleId($this->requestJsonBody["TitleId"], $this->requestJsonBody["ArtistId"]);
        //         }
        //         else
        //         {
        //             throw new Error("Id in Query or JSON with TitleId, ArtistId must be set!");
        //         }
        //         $result = array("successful" => true);
        //         $this->responseData = json_encode($result);
        //     } catch (Error $e) {
        //         $this->setErrorMsg($e->getMessage(), "", empty($this->strErrorHeader) ? HttpStatusCodesEnum::BadRequest->value : $this->strErrorHeader);
        //     }
        //     catch(Exception $e)
        //     {
        //         $errorBody = $e->getMessage()." The JSON cannot be processed. Please check your Object!";
        //         $this->setErrorMsg($e->getMessage(), $errorBody, HttpStatusCodesEnum::UnprocessableEntity->value);
        //     }
        //     $this->prepareOutput();
        // }
    }
?>