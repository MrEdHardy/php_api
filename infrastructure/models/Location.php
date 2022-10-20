<?php
    class Location extends DataBase implements IEntity
    {
        public function GetAllEntities()
        {
            $result = $this->Select("SELECT * FROM Lokation ORDER BY Id ASC");
            foreach ($result as $key => $value) 
            {
                $bool = json_decode($value["Active"]);
                $value["Active"] = (boolean)$bool;
                $result[$key] = $value;
            }
            return $result;
        }

        public function GetEntityById(int $id)
        {
            $result = $this->Select("SELECT * FROM Lokation WHERE Id = :Id", array(":Id" => $id));
            foreach ($result as $key => $value) 
            {
                $bool = json_decode($value["Active"]);
                $value["Active"] = (boolean)$bool;
                $result[$key] = $value;
            }
            return $result;
        }

        public function AddEntity(array $args)
        {
            $queryColumns = "";
            $queryValues = "";
            if(count($args) <= 0)
                throw new Exception("JSON is empty!");
            foreach ($args as $key => $value) 
            {
                if(strcasecmp($key, "Id") != 0)
                {
                    $queryColumns .= "$key,";
                    $queryValues .= "'$value',";
                }
            }
            $queryColumns[strlen($queryColumns) - 1] = " ";
            $queryValues[strlen($queryValues) - 1] = " ";
            $queryColumns = trim($queryColumns);
            $queryValues = trim($queryValues);
            $query = "INSERT INTO Lokation($queryColumns) VALUES($queryValues)";
            $mergedObject = array_merge($args, array("Id" => $this->Add($query)));
            return $mergedObject;
        }

        public function UpdateEntity(int $id, array $args)
        {
            $querySets = "";
            if(count($args) <= 0)
                throw new Exception("JSON is empty!");
            foreach ($args as $key => $value) 
            {
                if(strcasecmp($key, "Id") != 0)
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