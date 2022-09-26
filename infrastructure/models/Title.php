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
            return $this->Select("SELECT tc.Id FROM Künstler as k
            INNER JOIN Titelcollection tc ON tc.KünstlerId = k.Id
            INNER JOIN Titel t ON t.Id = tc.TitelId
            WHERE k.Id = :KId AND t.Id = :TId", array(":KId" => $artistId, ":TId" => $titleId));
        }

        public function GetTitleCollectionIdByArtistNameAndTitleName(string $titleName, string $artistName)
        {
            return $this->Select("SELECT tc.Id FROM Künstler as k
            INNER JOIN Titelcollection tc ON tc.KünstlerId = k.Id
            INNER JOIN Titel t ON t.Id = tc.TitelId
            WHERE k.[Name] = :KName AND t.[Name] = :TName", array(":KName" => $artistName, ":TName" => $titleName));
        }

        public function AddNewTitleCollectionEntry(array $args)
        {
            if(isset($args["TitleId"]) && isset($args["ArtistId"]))
            {
                return array("Id" => $this->Add("INSERT INTO Titelcollection VALUES(:TId, :KId)", array(":TId" => $args["TitleId"], ":KId" => $args["ArtistId"])));
            }
            else
            {
                throw new Exception("JSON is invalid!");
            }
        }

        public function UpdateTitleCollectionEntry(int $tcId, array $args)
        {
            if(isset($args["TitleId"]) && isset($args["ArtistId"]))
            {
                return array("successful" => $this->Update("UPDATE Titelcollection SET TitelId = :TId, KünstlerId = :KId WHERE Id = :Id ", 
                array(":TId" => $args["TitleId"], ":KId" => $args["ArtistId"], ":Id" => $tcId)));
            }
            else
            {
                throw new Exception("JSON is invalid!");
            }
        }

        public function DeleteTitleCollectionEntryById(int $id)
        {
            return $this->Delete("DELETE FROM Titelcollection WHERE Id = :Id", array(":Id" => $id));
        }

        public function DeleteTitleCollectionEntryByArtistIdAndTitleId(int $titleId, int $artistId)
        {
            return $this->Delete("DELETE TOP(1) FROM Titelcollection WHERE TitelId = :TId AND KünstlerId = :KId", 
            array(":TId" => $titleId, ":KId" => $artistId));
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