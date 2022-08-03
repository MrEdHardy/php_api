<?php
    class LocationController extends BaseController
    {
        private readonly Location $locationModel;

        public function __construct() 
        {
            $this->locationModel = new Location();
            parent::__construct();
        }

        /**
         * Endpoint ../locations/getalllocations
         */
        public function GetAllLocationsAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $result = $this->locationModel->GetAllEntities();
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
         * Endpoint ../locations/GetLocationById
         */
        public function GetLocationByIdAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::Id);
                $result = $this->locationModel->GetEntityById($this->queryArgsArray["Id"]);
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
         * Endpoint ../locations/UpdateLocation
         */
        public function UpdateLocationAction()
        {
            try 
            {
                $this->validateServerMethod("POST");
                $this->checkParams(RequiredFieldTypes::IdAndJSON);
                $result = $this->locationModel->UpdateEntity($this->queryArgsArray["Id"], $this->requestJsonBody);
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
         * Endpoint ../locations/AddLocation
         */
        public function AddLocationAction()
        {
            try 
            {
                $this->validateServerMethod("PUT");
                $this->checkParams(RequiredFieldTypes::JSON);
                $result = $this->locationModel->AddEntity($this->requestJsonBody);
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
         * Endpoint ../locations/deleteLocation
         */
        public function DeleteLocationAction()
        {
            try 
            {
                $this->validateServerMethod("DELETE");
                $this->checkParams(RequiredFieldTypes::Id);
                $this->locationModel->DeleteEntity($this->queryArgsArray["Id"], $this->requestJsonBody);
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
    }
?>