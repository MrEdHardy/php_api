<?php
    class Medium extends DataBase implements IEntity, IMedium, IMediumMediumCollection
    {
        public function GetAllEntities()
        {
            $result = $this->Select("SELECT * FROM [Medium] ORDER BY Id ASC");
            foreach ($result as $key => $value) 
            {
                $bool = json_decode($value["B-Seite"]);
                $value["B-Seite"] = (boolean)$bool;
                $result[$key] = $value;
            }
            return $result;
        }

        public function GetEntityById(int $id)
        {
            $result = $this->Select("SELECT * FROM [Medium] WHERE Id = :Id", array(":Id" => $id));
            foreach ($result as $key => $value) 
            {
                $bool = json_decode($value["B-Seite"]);
                $value["B-Seite"] = (boolean)$bool;
                $result[$key] = $value;
            }
            return $result;
        }

        public function UpdateEntity(int $id, array $args)
        {
            $querySets = "";
            foreach ($args as $key => $value) 
            {
                if(strcasecmp($key, "Id") != 0)
                    $querySets .= "[$key]='$value',";
            }
            $querySets[strlen($querySets) - 1] = " ";
            $querySets = trim($querySets);
            $query = "UPDATE [Medium] SET $querySets WHERE Id = $id";
            return array("successful" => $this->Update($query));
        }   

        public function AddEntity(array $args)
        {
            $queryColumns = "";
            $queryValues = "";
            foreach ($args as $key => $value) 
            {
                if(strcasecmp($key, "Id") != 0)
                {
                    $queryColumns .= "[$key],";
                    $queryValues .= "'$value',";
                }
            }
            $queryColumns[strlen($queryColumns) - 1] = " ";
            $queryValues[strlen($queryValues) - 1] = " ";
            $queryColumns = trim($queryColumns);
            $queryValues = trim($queryValues);
            $query = "INSERT INTO [Medium]($queryColumns) VALUES($queryValues)";
            $mergedObject = array_merge($args, array("Id" => $this->Add($query)));
            return $mergedObject;
        }

        public function DeleteEntity(int $id)
        {
            $this->Delete("DELETE FROM [Medium] WHERE Id = :Id", array(":Id" => $id));
        }

        public function GetCurrentId()
        {
            $this->Select("SELECT MAX(Id) FROM [Medium]");
        }

        public function GetMediumByLocationId(int $id)
        {
            return $this->Select("SELECT * FROM [Medium] WHERE LocationId = :Id", array(":Id" => $id));
        }

        public function GetMediumByMediumCollectionId(int $mcId)
        {
            return $this->Select("SELECT * FROM [Medium] m WHERE m.Id IN (SELECT MediumId FROM Mediumcollection WHERE Id = :mcId)", array(":mcId" => $mcId));
        }
    }
?>