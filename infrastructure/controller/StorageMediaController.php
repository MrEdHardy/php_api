<?php
    class StorageMediaController extends BaseController
    {
        private readonly StorageMedia $smModel;

        public function __construct() 
        {
            $this->smModel = new StorageMedia();
            parent::__construct();
        }

        /**
         * Endpoint ../storagemedia/getallstoragemedia
         */
        public function GetAllStorageMediaAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $result = $this->smModel->GetAllEntities();
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
         * Endpoint ../storagemedia/getstoragemediabyid
         */
        public function GetStorageMediaByIdAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::Id);
                $result = $this->smModel->GetEntityById($this->queryArgsArray["Id"]);
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
         * Endpoint ../storagemedia/UpdateStorageMedia
         */
        public function UpdateStorageMediaAction()
        {
            try 
            {
                $this->validateServerMethod("POST");
                $this->checkParams(RequiredFieldTypes::IdAndJSON);
                $result = $this->smModel->UpdateEntity($this->queryArgsArray["Id"], $this->requestJsonBody);
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
         * Endpoint ../storagemedia/AddStorageMedia
         */
        public function AddStorageMediaAction()
        {
            try 
            {
                $this->validateServerMethod("PUT");
                $this->checkParams(RequiredFieldTypes::JSON);
                $result = $this->smModel->AddEntity($this->requestJsonBody);
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
         * Endpoint ../storagemedia/deleteStorageMedia
         */
        public function DeleteStorageMediaAction()
        {
            try 
            {
                $this->validateServerMethod("DELETE");
                $this->checkParams(RequiredFieldTypes::IdOrName);
                if(isset($this->queryArgsArray["Id"]))
                {
                    $this->smModel->DeleteEntity($this->queryArgsArray["Id"]);
                }
                else
                {
                    $result = $this->smModel->DeleteStorageMediaByName($this->queryArgsArray["Name"]);
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

        /**
         * Endpoint ../storagemedia/GetStorageMediaByGenre
         */
        public function GetStorageMediaByGenreAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::customSimpleField, "Genre");
                $result = $this->smModel->GetStorageMediaByGenre($this->queryArgsArray["Genre"]);
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
         * Endpoint ../storagemedia/GetStorageMediaByDate
         */
        public function GetStorageMediaByDateAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::JSON);
                $result = $this->smModel->GetStorageMediaByDate($this->requestJsonBody);
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
         * Endpoint ../storagemedia/GetStorageMediaByArtist
         */
        public function GetStorageMediaByArtistAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::IdOrName);
                if(isset($this->queryArgsArray["Id"]))
                {
                    $result = $this->smModel->GetStorageMediaByArtistId($this->queryArgsArray["Id"]);
                }
                else
                {
                    $result = $this->smModel->GetStorageMediaByArtistName($this->queryArgsArray["Name"]);
                }
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
         * Endpoint ../storagemedia/GetAllArtistCollections
         */
        public function GetAllArtistCollectionsAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $result = $this->smModel->GetAllArtistCollections();
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
         * Endpoint ../storagemedia/GetArtistCollectionById
         */
        public function GetArtistCollectionByIdAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::Id);
                $result = $this->smModel->GetArtistCollectionById($this->queryArgsArray["Id"]);
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
         * Endpoint ../storagemedia/getartistcollectionidsbyartistandstoragemedia
         */
        public function GetArtistCollectionIdsByArtistAndStoragemediaAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::JSON);
                if(isset($this->requestJsonBody["MusikträgerId"]) && isset($this->requestJsonBody["KünstlerId"]))
                {
                    $result = $this->smModel
                    ->GetArtistCollectionIdByStorageMediaIdAndArtistId($this->requestJsonBody["MusikträgerId"], $this->requestJsonBody["KünstlerId"]);
                }
                elseif(isset($this->requestJsonBody["StorageMediaName"]) && isset($this->requestJsonBody["ArtistName"]))
                {
                    $result = $this->smModel
                    ->GetArtistCollectionIdByStorageMediaNameAndArtistName($this->requestJsonBody["StorageMediaName"], $this->requestJsonBody["ArtistName"]);
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
         * Endpoint ../storagemedia/addnewArtistcollectionentry
         */
        public function AddNewArtistCollectionEntryAction()
        {
            try 
            {
                $this->validateServerMethod("PUT");
                $this->checkParams(RequiredFieldTypes::JSON);
                if(isset($this->requestJsonBody["MusikträgerId"]) && isset($this->requestJsonBody["KünstlerId"]))
                {
                    $result = $this->smModel
                    ->AddNewArtistCollectionEntry($this->requestJsonBody["MusikträgerId"], $this->requestJsonBody["KünstlerId"]);
                }
                else
                {
                    throw new Error("JSON is invalid!");
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
         * Endpoint ../storagemedia/updateartistcollectionentry
         */
        public function UpdateArtistCollectionEntryAction()
        {
            try 
            {
                $this->validateServerMethod("POST");
                $this->checkParams(RequiredFieldTypes::IdAndJSON);
                if(isset($this->requestJsonBody["MusikträgerId"]) && isset($this->requestJsonBody["KünstlerId"]))
                {
                    $result = $this->smModel
                    ->UpdateArtistCollectionEntry($this->queryArgsArray["Id"], $this->requestJsonBody["MusikträgerId"], $this->requestJsonBody["KünstlerId"]);
                }
                else
                {
                    throw new Error("JSON is invalid!");
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
         * Endpoint ../storagemedia/deleteartistcollectionentry
         */
        public function DeleteArtistCollectionEntryAction()
        {
            try 
            {
                $this->validateServerMethod("DELETE");
                $this->checkParams(RequiredFieldTypes::IdOrJSON);
                if(isset($this->queryArgsArray["Id"]))
                {
                    $this->smModel->DeleteArtistCollectionEntryById($this->queryArgsArray["Id"]);
                }
                elseif(count($this->requestJsonBody) > 0 && isset($this->requestJsonBody["MusikträgerId"]) && isset($this->requestJsonBody["KünstlerId"]))
                {
                    $this->smModel->DeleteArtistCollectionEntryByArtistIdAndTitleId($this->requestJsonBody["MusikträgerId"], $this->requestJsonBody["KünstlerId"]);
                }
                else
                {
                    throw new Error("Id in Query or JSON with StorageMediaId, ArtistId must be set!");
                }
                $result = array("successful" => true);
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

        /**
         * Endpoint ../storagemedia/GetStorageMediaByMediumCollectionId
         */
        public function GetStorageMediaByMediumCollectionIdAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::Id);
                $result = $this->smModel->GetStorageMediaByMediumCollectionId($this->queryArgsArray["Id"]);
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
    }
?>