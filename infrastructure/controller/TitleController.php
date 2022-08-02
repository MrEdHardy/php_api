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
    }
?>