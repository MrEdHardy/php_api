<?php
    class MediumCollection extends DataBase implements IEntity, IMediumCollection
    {
        public function GetAllEntities()
        {
            return $this->Select("SELECT * FROM Mediumcollection ORDER BY Id ASC");
        }

        public function GetEntityById(int $id)
        {
            return $this->Select("SELECT * FROM Mediumcollection WHERE Id = :Id", array(":Id" => $id));
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
            $query = "UPDATE Mediumcollection SET $querySets WHERE Id = $id";
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
            $query = "INSERT INTO Mediumcollection($queryColumns) VALUES($queryValues)";
            return array("Id" => $this->Add($query));
        }

        public function DeleteEntity(int $id)
        {
            $this->Delete("DELETE FROM Mediumcollection WHERE Id = :Id", array(":Id" => $id));
        }

        public function GetCurrentId()
        {
            return $this->Select("SELECT MAX(Id) FROM Mediumcollection");
        }

        public function GetMediumCollectionsByType(string $type)
        {
            return $this->Select("SELECT * FROM Mediumcollection WHERE [Type] = :type", array(":type" => $type));
        }

        public function GetMediumCollectionsByMediumId(int $medId)
        {
            return $this->Select("SELECT * FROM Mediumcollection WHERE MediumId = :Id", array(":Id" => $medId));
        }

        public function GetMediumCollectionsByStorageMediaId(int $smId)
        {
            return $this->Select("SELECT * FROM Mediumcollection WHERE MusikträgerId = :Id", array(":Id" => $smId));
        }

        public function GetMediumCollectionsByTitleCollectionId(int $tcId)
        {
            return $this->Select("SELECT * FROM Mediumcollection WHERE TitelcollectionId = :Id", array(":Id" => $tcId));
        }
    }
?>