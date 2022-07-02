<?php
    class Artist extends Database implements IEntity, IArtist, IArtistTitle
    {
        public function GetAllEntities()
        {
            return $this->select("SELECT * FROM Künstler ORDER BY Id ASC");
        }

        public function GetEntityById(int $id)
        {
            return $this->select("SELECT * FROM Künstler WHERE Id = :Id", array(":Id" => $id));
        }

        public function UpdateEntity(int $id, array $keyValuePairs)
        {
            $querySets = "";
            foreach ($keyValuePairs as $key => $value) {
                $querySets .= "$key='$value',";
            }
            $querySets[strlen($querySets) - 1] = " ";
            $querySets = trim($querySets);
            $query = "UPDATE Künstler SET $querySets WHERE Id = $id";
            return $this->Update($query);
        }

        public function AddEntity(array $args)
        {
            $queryColumns = "";
            $queryValues = "";
            foreach ($args as $key => $value) {
                $queryColumns .= "$key,";
                $queryValues .= "'$value',";
            }
            $queryColumns[strlen($queryColumns) - 1] = " ";
            $queryValues[strlen($queryValues) - 1] = " ";
            $queryColumns = trim($queryColumns);
            $queryValues = trim($queryValues);
            $query = "INSERT INTO Künstler($queryColumns) VALUES($queryValues)";
            // return $this->Add($query, array(":Col" => "Künstler"));
            return $this->Add($query);
        }

        public function DeleteEntity(int $id)
        {
            return $this->Delete("DELETE FROM Künstler WHERE Id = $id");
        }

        public function DeleteArtistByName(int $name)
        {
            return $this->Delete("DELETE FROM Künstler WHERE [Name] = $name");
        }
        
        public function GetCurrentId()
        {
            return $this->GetCurrentMaxId("Künstler");
        }

        public function GetArtistsByTitleId(int $id)
        {
            return $this->Select("SELECT k.* FROM Künstler as k
            INNER JOIN Titelcollection tc ON tc.KünstlerId = k.Id
            INNER JOIN Titel t ON t.Id = tc.Id
            WHERE k.Id = :Id", array(":Id" => $id));
        }

        public function GetArtistsByTitleName(string $name)
        {
            return $this->Select("SELECT k.* FROM Künstler as k
            INNER JOIN Titelcollection tc ON tc.KünstlerId = k.Id
            INNER JOIN Titel t ON t.Id = tc.Id
            WHERE k.Name = :Name", array(":Name" => $name));
        }
        
        public function GetTitleCollectionIdByArtistIdAndTitleId(int $titleId, int $artistId)
        {
            return $this->Select("SELECT tc.Id FROM Künstler as k
            INNER JOIN Titelcollection tc ON tc.KünstlerId = k.Id
            INNER JOIN Titel t ON t.Id = tc.Id
            WHERE k.Id = :KId AND t.Id = :TId", array(":KId" => $artistId, ":TId" => $titleId));
        }

        public function GetTitleCollectionIdByArtistNameAndTitleName(string $titleName, string $artistName)
        {
            return $this->Select("SELECT tc.Id FROM Künstler as k
            INNER JOIN Titelcollection tc ON tc.KünstlerId = k.Id
            INNER JOIN Titel t ON t.Id = tc.Id
            WHERE k.Name = :KName AND t.Name = :TName", array(":KName" => $artistName, ":TName" => $titleName));
        }

        public function AddNewTitleCollectionEntry(int $titleId, int $artistId)
        {
            return $this->Add("INSERT INTO Titelcollection VALUES(:TId, :KId)", array(":TId" => $titleId, ":KId" => $artistId));
        }

        public function UpdateTitleCollectionEntry(int $tcId, int $newTitleId, int $newArtistId)
        {
            return $this->Update("UPDATE Titelcollection SET TitelId = :TId, KünstlerId = :KId WHERE Id = :Id ", 
            array(":TId" => $newTitleId, ":KId" => $newArtistId, ":Id" => $tcId));
        }

        public function DeleteTitleCollectionEntryById(int $id)
        {
            return $this->Delete("DELETE FROM Künstlercollection WHERE Id = :Id", array(":Id" => $id));
        }

        public function DeleteTitleCollectionEntryByArtistIdAndTitleId(int $titleId, int $artistId)
        {
            return $this->Delete("DELETE FROM Künstlercollection WHERE TitelId = :TId AND KünstlerId = :KId", 
            array(":TId" => $titleId, ":KId" => $artistId));
        }
    }
?>