<?php
    class TestModel extends Database
    {
        public function getAllArtists()
        {
            return $this->Select("SELECT * FROM Künstler ORDER BY Id ASC");
        }

        // public function InsertArtist()
        // {
        //     return $this->Add("INSERT INTO Künstler VALUES('lolrofl')", null);
        // }
    }
?>