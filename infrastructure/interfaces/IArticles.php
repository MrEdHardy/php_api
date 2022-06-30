<?php
    interface IArticles {
        public function GetAllArtists();
        public function GetArtistsById(int $id);
        public function UpdateArtist(int $id, array $keyValuePairs);
        public function AddArtist(array $keyValuePairs);
        public function DeleteArtist(int $id);
        public function GetCurrentId();
    }
?>