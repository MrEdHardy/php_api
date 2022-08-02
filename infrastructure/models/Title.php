<?php
    class Title extends DataBase implements IEntity, ITitle, IArtistTitle
    {
        public function GetAllEntities()
        {
            return $this->Select("SELECT * FROM Titel ORDER BY Id ASC");
        }

        public function GetEntityById(int $id)
        {
            return $this->Select("SELECT * FROM Titel WHERE Id = :Id", array(":Id" => $id));
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
            $query = "UPDATE Titel SET $querySets WHERE Id = $id";
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
            $query = "INSERT INTO Titel($queryColumns) VALUES($queryValues)";
            return array("Id" => $this->Add($query));
        }
        public function DeleteEntity(int $id)
        {
            return $this->Delete("DELETE FROM Titel WHERE Id = $id");
        }

        public function DeleteTitlesByName(string $name)
        {
            return $this->Delete("DELETE FROM Titel WHERE [Name] = '$name'");
        }

        public function GetCurrentId()
        {
            return $this->GetCurrentMaxId("Titel");
        }

        public function GetTitleCollectionIdByArtistIdAndTitleId(int $titleId, int $artistId)
        {

        }

        public function GetTitleCollectionIdByArtistNameAndTitleName(string $titleName, string $artistName)
        {

        }

        public function AddNewTitleCollectionEntry(int $titleId, int $artistId)
        {

        }

        public function UpdateTitleCollectionEntry(int $tcId, int $newTitleId, int $newArtistId)
        {

        }

        public function DeleteTitleCollectionEntryById(int $id)
        {

        }

        public function DeleteTitleCollectionEntryByArtistIdAndTitleId(int $titleId, int $artistId)
        {

        }

        public function GetTitlesByArticleId(int $id)
        {
            return $this->Select("SELECT DISTINCT t.* FROM Künstler as k
            INNER JOIN Titelcollection tc ON tc.KünstlerId = k.Id
            INNER JOIN Titel t ON t.Id = tc.TitelId
            WHERE k.Id = :Id", array(":Id" => $id));
        }

        public function GetTitlesByArticleName(string $name)
        {
            return $this->Select("SELECT DISTINCT t.* FROM Künstler as k
            INNER JOIN Titelcollection tc ON tc.KünstlerId = k.Id
            INNER JOIN Titel t ON t.Id = tc.TitelId
            WHERE k.Name = :Name", array(":Name" => $name));
        }
    }
?>