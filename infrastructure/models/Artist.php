<?php
    class Artist extends Database implements IArticles
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

        public function DeleteArtist(int $id)
        {
            # code...
        }
        
        public function GetCurrentId()
        {
            return $this->GetCurrentMaxId("Künstler");
        }
    }
?>