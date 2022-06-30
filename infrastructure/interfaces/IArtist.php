<?php
    interface IArtist {
        public function GetAllArtists();
        public function GetArtistsById(int $id);
        public function UpdateArtist(int $id, array $keyValuePairs);
        public function AddArtist(array $keyValuePairs);
        public function DeleteArtistById(int $id);
        public function GetCurrentId();
    }
?>