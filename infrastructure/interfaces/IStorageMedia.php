<?php
    interface IStorageMedia
    {
        public function GetStorageMediaByGenre(string $genre);
        public function GetStorageMediaByDate(array $args);
        public function GetStorageMediaByArtistId(int $id);
        public function GetStorageMediaByArtistName(string $name);
        public function DeleteStorageMediaByName(string $name);
    }
?>