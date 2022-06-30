<?php
    class Artist extends Database implements IArtist, IArtistTitle
    {
        public function GetAllArtists()
        {
            return $this->select("SELECT * FROM Künstler ORDER BY Id ASC");
        }

        public function GetArtistsById(int $id)
        {
            return $this->select("SELECT * FROM Künstler WHERE Id = :Id", array(":Id" => $id));
        }

        public function UpdateArtist(int $id, array $keyValuePairs)
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

        public function AddArtist(array $args)
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
            return $this->Add($query, array(":Col" => "Künstler"));
        }

        public function DeleteArtistById(int $id)
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
    }
?>