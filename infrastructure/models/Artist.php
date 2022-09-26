<?php
    class Artist extends Database implements IEntity, IArtist, IArtistTitle
    {
        private string $column = "Künstler";
        public function GetAllEntities()
        {
            return $this->Select("SELECT * FROM Künstler ORDER BY Id ASC");
        }

        public function GetEntityById(int $id)
        {
            return $this->Select("SELECT * FROM Künstler WHERE Id = :Id", array(":Id" => $id));
        }

        public function UpdateEntity(int $id, array $args)
        {
            return $this->BuildAndExecuteUpdateEntityQuery($id, $args, $this->column);
        }

        public function AddEntity(array $args)
        {
            return $this->BuildAndExecuteAddEntityQuery($args, $this->column);
        }

        public function DeleteEntity(int $id)
        {
            return $this->Delete("DELETE FROM Künstler WHERE Id = $id");
        }

        public function DeleteArtistByName(string $name)
        {
            return $this->Delete("DELETE FROM Künstler WHERE [Name] = '$name'");
        }
        
        public function GetCurrentId()
        {
            return $this->GetCurrentMaxId($this->column);
        }

        public function GetArtistsByTitleId(int $id)
        {
            return $this->Select("SELECT DISTINCT k.* FROM Künstler as k
            INNER JOIN Titelcollection tc ON tc.KünstlerId = k.Id
            INNER JOIN Titel t ON t.Id = tc.TitelId
            WHERE t.Id = :Id", array(":Id" => $id));
        }

        public function GetArtistsByTitleName(string $name)
        {
            return $this->Select("SELECT DISTINCT k.* FROM Künstler as k
            INNER JOIN Titelcollection tc ON tc.KünstlerId = k.Id
            INNER JOIN Titel t ON t.Id = tc.TitelId
            WHERE t.Name = :Name", array(":Name" => $name));
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
                return array("Id" => 
                    $this->Add("INSERT INTO Titelcollection VALUES(:TId, :KId)", array(":TId" => $args["TitleId"], ":KId" => $args["ArtistId"])));
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
    }
?>