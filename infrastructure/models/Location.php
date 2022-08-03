<?php
    class Location extends DataBase implements IEntity
    {
        public function GetAllEntities()
        {
            return $this->Select("SELECT * FROM Lokation ORDER BY Id ASC");
        }

        public function GetEntityById(int $id)
        {
            return $this->Select("SELECT * FROM Lokation WHERE Id = :Id", array(":Id" => $id));
        }

        public function AddEntity(array $args)
        {
            $queryColumns = "";
            $queryValues = "";
            if(count($args) <= 0)
                throw new Exception("JSON is empty!");
            foreach ($args as $key => $value) 
            {
                $queryColumns .= "$key,";
                $queryValues .= "'$value',";
            }
            $queryColumns[strlen($queryColumns) - 1] = " ";
            $queryValues[strlen($queryValues) - 1] = " ";
            $queryColumns = trim($queryColumns);
            $queryValues = trim($queryValues);
            $query = "INSERT INTO Lokation($queryColumns) VALUES($queryValues)";
            return array("Id" => $this->Add($query));
        }

        public function UpdateEntity(int $id, array $args)
        {
            $querySets = "";
            if(count($args) <= 0)
                throw new Exception("JSON is empty!");
            foreach ($args as $key => $value) 
            {
                $querySets .= "$key='$value',";
            }
            $querySets[strlen($querySets) - 1] = " ";
            $querySets = trim($querySets);
            $query = "UPDATE Lokation SET $querySets WHERE Id = $id";
            return array("successful" => $this->Update($query));
        }

        public function DeleteEntity(int $id)
        {
            return $this->Delete("DELETE FROM Lokation WHERE Id = $id");
        }

        public function GetCurrentId()
        {
            return $this->GetCurrentMaxId("Lokation");
        }
    }
?>