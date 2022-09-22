<?php
    class MediumController extends BaseController
    {
        private readonly Medium $mediumModel;
        
        public function __construct()
        {
            $this->mediumModel = new Medium();
            parent::__construct();
        }

        /**
         * Endpoint ../media/getallmedia
         */
        public function GetAllMediaAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $result = $this->mediumModel->GetAllEntities();
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
         * Endpoint ../Media/GetMediumById
         */
        public function GetMediumByIdAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::Id);
                $result = $this->mediumModel->GetEntityById($this->queryArgsArray["Id"]);
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
         * Endpoint ../Media/UpdateMedium
         */
        public function UpdateMediumAction()
        {
            try 
            {
                $this->validateServerMethod("POST");
                $this->checkParams(RequiredFieldTypes::IdAndJSON);
                $result = $this->mediumModel->UpdateEntity($this->queryArgsArray["Id"], $this->requestJsonBody);
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
         * Endpoint ../Media/AddMedium
         */
        public function AddMediumAction()
        {
            try 
            {
                $this->validateServerMethod("PUT");
                $this->checkParams(RequiredFieldTypes::JSON);
                $result = $this->mediumModel->AddEntity($this->requestJsonBody);
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
         * Endpoint ../Media/deleteMedium
         */
        public function DeleteMediumAction()
        {
            try 
            {
                $this->validateServerMethod("DELETE");
                $this->checkParams(RequiredFieldTypes::Id);
                $this->mediumModel->DeleteEntity($this->queryArgsArray["Id"]);
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
         * Endpoint ../Media/getMediumByLocationId
         */
        public function GetMediumByLocationIdAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::Id);
                $result = $this->mediumModel->GetMediumByLocationId($this->queryArgsArray["Id"]);
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
         * Endpoint ../Media/getMediumByMediumCollectionId
         */
        public function GetMediumByMediumCollectionIdAction()
        {
            try 
            {
                $this->validateServerMethod("GET");
                $this->checkParams(RequiredFieldTypes::Id);
                $result = $this->mediumModel->GetMediumByMediumCollectionId($this->queryArgsArray["Id"]);
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