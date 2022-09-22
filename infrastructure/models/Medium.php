<?php
    class Medium extends DataBase implements IEntity, IMedium, IMediumMediumCollection
    {
        public function GetAllEntities()
        {
            return $this->Select("SELECT * FROM [Medium] ORDER BY Id ASC");
        }

        public function GetEntityById(int $id)
        {
            return $this->Select("SELECT * FROM [Medium] WHERE Id = :Id", array(":Id" => $id));
        }

        public function UpdateEntity(int $id, array $args)
        {
            $querySets = "";
            foreach ($args as $key => $value) 
            {
                $querySets .= "$key='$value',";
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
                $queryColumns .= "$key,";
                $queryValues .= "'$value',";
            }
            $queryColumns[strlen($queryColumns) - 1] = " ";
            $queryValues[strlen($queryValues) - 1] = " ";
            $queryColumns = trim($queryColumns);
            $queryValues = trim($queryValues);
            $query = "INSERT INTO [Medium]($queryColumns) VALUES($queryValues)";
            return array("Id" => $this->Add($query));
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